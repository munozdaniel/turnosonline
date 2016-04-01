<?php
//obtenemos el adaptador que crea la paginación en Phalcon
use \Phalcon\Paginator\Adapter\Model as Paginacion;
use \Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use \Phalcon\Paginator\Adapter\QueryBuilder as PaginacionBuilder;

class TurnosController extends ControllerBase
{
    /**
     * Inicializa el controlador turnos con el template admin, ya que la mayoria de  las acciones
     * se ejecutan estando logueado. Para aquellas paginas que no necesitan login se setean los template
     * manualmente para cada accion.
     */
    public function initialize()
    {
        $this->tag->setTitle('Turnos Online');
        $this->view->setTemplateAfter('admin');
        $this->importarFechaFirefox();
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
        parent::initialize();
    }

    /**
     * Encargado de seleccionar el layout main para las paginas que no necesitan registro.
     */
    private function menuPpal()
    {
        $this->view->setTemplateAfter('main');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
    }

    /*================================ INVITADOS =======================================*/

    public function indexAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if ($ultimoPeriodo) {
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos <= $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $turnosOnlineForm = new TurnosOnlineForm(null, array('disabled' => 'true'));
                $this->view->deshabilitar = true;
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
            } else {
                $turnosOnlineForm = new TurnosOnlineForm();
            }
        } else {
            $turnosOnlineForm = new TurnosOnlineForm(null, array('disabled' => 'true'));
            $this->flash->error("EL PERIODO PARA SOLICITAR TURNOS NO SE ENCUENTRA DISPONIBLE.");
            $this->view->deshabilitar = true;
        }
        $this->view->formulario = $turnosOnlineForm;
    }

    /**
     * Muestra el formulario para solicitar turno.
     * 0. VERIFICA QUE HAY TURNOS DISPONIBLES.
     * 1. valida sus campos.
     * 2. valida si esta dentro del periodo disponible para solicitar turnos.
     * 3. verifica si los datos ingresados pertenecen a un afiliado de siprea y verifica si hay cupos disponibles
     * 4. verifica que no haya solicitado otro turno en el periodo actual.
     * 5.
     */
    public function guardarTurnoOnlineAction()
    {
        if (!$this->request->isPost()) {
            $this->response->redirect('index/index');
        }
        $this->view->setTemplateAfter('admin');
        $turnosOnlineForm = new TurnosOnlineForm();
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if ($ultimoPeriodo) {
            /*================== Controlo la cantidad de turnos ========================*/
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos <= $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $turnosOnlineForm = new TurnosOnlineForm(null, array('disabled' => 'true'));
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
            } /* ==================================================================================== */
            else {
                $data = $this->request->getPost();

                if ($turnosOnlineForm->isValid($data) != false) //aqui es donde valida los datos ingresados
                {
                    $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                    $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                    $nombre = rtrim($nombre);
                    $nombre = ltrim($nombre);
                    $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                    $apellido = rtrim($apellido);
                    $apellido = ltrim($apellido);
                    $documento = $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string'));
                    $numTelefono = $this->request->getPost('solicitudTurno_numTelefono', 'int');
                    $email = $this->request->getPost('solicitudTurno_email', array('email', 'trim'));

                    $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);

                    if ($nombreCompleto != "") {
                        if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto)) {
                            if (!$this->existeEmailEnElPeriodo($ultimoPeriodo, $email)) {
                                $seGuardo = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email, $numTelefono, $ultimoPeriodo->fechasTurnos_id);

                                if ($seGuardo)//la solicitud se ingreso con exito.
                                {
                                    $this->flash->success('LA SOLICITUD FUE INGRESADA CORRECTAMENTE');
                                    $turnosOnlineForm->clear();
                                    $this->redireccionar('turnos/turnoSolicitadoExitoso');
                                } else
                                    $this->flash->error('OCURRIO UN PROBLEMA, POR FAVOR VUELVA A INTENTARLO EN UNOS MINUTOS.');
                            } else {
                                $this->flash->error('EL EMAIL INGRESADO YA HA SIDO UTILIZADO PAR SOLICITAR UN TURNO.');
                            }
                        } else
                            $this->flash->error('SUS DATOS YA FUERON INGRESADOS, NO PUEDE OBTENER MÁS DE UN TURNO POR PERÍODO');
                    } else
                        $this->flash->error('USTED NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA OBTENER MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.');
                } else {
                    foreach ($turnosOnlineForm->getMessages() as $mje) {
                        $this->flash->error($mje);
                    }
                }
            }
        } else {
            $turnosOnlineForm = new TurnosOnlineForm(null, array('disabled' => 'true'));
            $this->flash->message('problema', 'NO EXISTE EL PERIODO PARA SOLICITAR TURNOS.');
        }
        $this->view->formulario = $turnosOnlineForm;
        return $this->redireccionar('turnos/index');

    }

    /**
     * Verifica si el correo ya fue utilizado para solicitar un turno en el periodo activo
     * @param $email
     */
    private function existeEmailEnElPeriodo($ultimoPeriodo, $email)
    {
        $solicitud = Solicitudturno::findFirst(
            array("conditions" => "solicitudTurnos_fechasTurnos=:fechasTurnos_id: AND solicitudTurno_email = :email:",
                "bind" => array("fechasTurnos_id" => $ultimoPeriodo->fechasTurnos_id, "email" => $email))
        );
        if ($solicitud)
            return true;
        return false;
    }

    /**
     * Muestra el formulario para guardar un solicitud manual.
     * ================================================================================================================
     */
    public function solicitudManualAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if ($ultimoPeriodo) {
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos > $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $this->view->cantAutorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
                $this->view->cantTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
                $this->view->fechaI = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
                $this->view->fechaF = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
                $this->view->diaA = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
                $turnosOnlineForm = new TurnoForm();
            } else {
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
                return $this->redireccionar('administrar/index');
            }
        } else {
            $this->flash->error("EL PERIODO PARA SOLICITAR TURNOS MANUALES NO SE ENCUENTRA DISPONIBLE.");
            return $this->redireccionar('administrar/index');
        }
        $this->view->formulario = $turnosOnlineForm;
    }

    /**
     * Guarda la solicitud manual.
     */
    public function guardarSolicitudManualAction()
    {
        if (!$this->request->isPost()) {
            $this->redireccionar('index/index');
        }
        $turnoManualForm = new TurnoForm();
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if (!empty($ultimoPeriodo)) {
            $this->view->cantAutorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
            $this->view->cantTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
            $this->view->fechaI = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
            $this->view->fechaF = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
            $this->view->diaA = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos <= $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $turnoManualForm = new TurnoForm(null, array('disabled' => 'true'));
                $this->view->deshabilitar = true;
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
            } else {
                $turnoManualForm = new TurnoForm();
            }

            if ($turnoManualForm->isValid($this->request->getPost()) != false) //aqui es donde valida los datos ingresados
            {
                $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                $nombre = rtrim($nombre);
                $nombre = ltrim($nombre);
                $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                $apellido = rtrim($apellido);
                $apellido = ltrim($apellido);
                $documento = $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string'));
                $numTelefono = $this->request->getPost('solicitudTurno_numTelefono', 'int');
                $estado = $this->request->getPost('estado');
                $miSesion = $this->session->get('auth');
                $nickActual = $miSesion['usuario_nick'];

                $fechaTurno = Fechasturnos::findFirstByFechasTurnos_activo(1);

                if ($fechaTurno->fechasTurnos_inicioSolicitud <= date('Y-m-d') && date('Y-m-d') <= $fechaTurno->fechasTurnos_finSolicitud) {
                    $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);

                    if ($nombreCompleto != "") {
                        if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto, null)) {
                            $nroTurno = null;
                            if ($estado == 'AUTORIZADO') {
                                if ($fechaTurno->fechasTurnos_sinTurnos == 1) {
                                    $nroTurno = 1;
                                    $fechaTurno->fechasTurnos_sinTurnos = 0;
                                    if (!$fechaTurno->update())
                                        $this->flash->error('OCURRIO UN ERROR AL GENERAR EL Nº DE TURNO.');
                                } else {
                                    $solicitud = new Solicitudturno();
                                    $nroTurno = $solicitud->obtenerUltimoNumero() + 1;
                                }
                            }

                            $solicitud = Solicitudturno::accionAgregarUnaSolicitudManual($legajo, $nombreCompleto, $documento, $numTelefono, $estado, $nickActual, $nroTurno, $ultimoPeriodo->fechasTurnos_id);

                            if (!empty($solicitud))//la solicitud se ingreso con exito.
                            {
                                if ($estado == 'AUTORIZADO') {
                                    Fechasturnos::incrementarCantAutorizados();
                                    $turnoManualForm->clear();
                                    $boton = $this->tag->form(array('turnos/comprobanteTurnoPost', 'method' => 'POST'));
                                    $encode = base64_encode($solicitud->solicitudTurno_id);
                                    $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $encode));
                                    $boton .= "<button type='submit' class='btn btn-info btn-lg' formtarget='_blank'><i class='fa fa-print'></i> IMPRIMIR COMPROBANTE DE TURNO</button>";
                                    $boton .= "</form>";
                                    $this->flash->notice($boton);
                                }

                            } else
                                $this->flash->error('OCURRIO UN ERROR, INTENTE MAS TARDE.');
                        } else
                            $this->flash->error('EL AFILIADO YA SOLICITO UN TURNO, POR LO CUAL NO SE PUEDE INGRESAR ESTA SOLICITUD.');
                    } else
                        $this->flash->error('EL AFILIADO NO ESTA REGISTRADO EN EL SISTEMA O ALGUNO DE LOS DATOS INGRESADOS SON INCORRECTOS.');
                } else
                    $this->flash->error('NO ES POSIBLE INGRESAR LA SOLICITUD EN LA FECHA ACTUAL. VERIFIQUE EL PERIODO DE SOLICITUD.');
            }
        } else {
            $this->view->cantAutorizados = -1;
            $this->view->cantTurnos = -1;
            $this->view->fechaI = '-';
            $this->view->fechaF = '-';
            $this->view->diaA = '-';
            $this->flash->message('problema', 'NO HAY NINGÚN PERIODO HABILITADO PARA SOLICITAR TURNOS.');
        }
        $this->view->formulario = $turnoManualForm;
        return $this->redireccionar('turnos/solicitudManual');

    }

    /**
     * Verifica que los datos ingresados por parametros se encuentren en la bd de siprea.
     * @param $legajo Corresponde al legajo del afiliado.
     * @param $nombreCompleto Corresponde a los apellidos concatenados con los nombres, separados por espacio.
     * No es necesario que este completo.
     * @return String Devuelve el nombreCompleto que si se encontro en la bd, sino vacio.
     */
    private function comprobarDatosEnSiprea($legajo, $nombreCompleto)
    {
        try {
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom FROM siprea2.afiliados AS AF WHERE (AF.afiliado_apenom LIKE '%" . $nombreCompleto . "%') AND (AF.afiliado_legajo LIKE '%" . $legajo . "%') AND (AF.afiliado_activo = 1);";
            $result = $this->dbSiprea->query($sql);
            $texto = '';

            if ($result->numRows() != 0) {
                $afiliados = $result->fetch();
                $texto = $afiliados["afiliado_apenom"];
            }
            return $texto;
        } catch (Phalcon\Db\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
        }
        return "";
    }


    /**
     * Verifica con los datos del afiliado si ya solicito un turno en este periodo.
     * MJE ERROR: SUS DATOS YA FUERON INGRESADO, NO PUEDE SACAR MÁS DE UN TURNO POR PERÍODO
     * @return boolean devuelve si encontro o no.
     */
    private function tieneTurnoSolicitado($legajo, $nomApe)
    {
        try {
            $consulta = "SELECT ST.* FROM solicitudturno AS ST, Fechasturnos AS F WHERE (fechasTurnos_activo = 1)
                        AND (F.fechasTurnos_id = ST.solicitudTurnos_fechasTurnos) AND ((ST.solicitudTurno_legajo=:legajo:)
                        OR (ST.solicitudTurno_nomApe LIKE  :nomApe:))";

            $solicitudTurno = $this->modelsManager->executeQuery($consulta,
                array(
                    'legajo' => $legajo,
                    'nomApe' => $nomApe));
            //Si no encontro datos, es porque no solicito un turno en este periodo.
            if (count($solicitudTurno) == 0)
                return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
        return true;
    }


    public function turnoSolicitadoExitosoAction()
    {
        //este action solo se utiliza para poder redireccionarse a la vista correspondiente.
    }

    /*================================ SUPERVISOR =======================================*/
    public function periodoSolicitudAction()
    {
        $this->view->formulario = new PeriodoSolicitudForm();
    }

    /**
     * Muestra el formulario para crear un nuevo periodo para solicitar turnos, lo valida y guarda en la base de datos.
     * Rol: Supervisor/Administrador
     */
    public function guardarPeriodoSolicitudAction()
    {
        $this->view->pick('turnos/periodoSolicitud');
        $periodoSolicitudForm = new PeriodoSolicitudForm();
        $this->view->formulario = $periodoSolicitudForm;

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if ($periodoSolicitudForm->isValid($data) != false) {
                //Comprobamos que: fechasTurnos_finSolicitud + cantidadDiasConfirmacion < fechasTurnos_diaAtencion
                $cantidadDiasConfirmacion = $this->request->getPost('cantidadDias', 'int');
                $periodoSolicitudHasta = $this->request->getPost('periodoSolicitudHasta');
                $periodoDiaAtencion = $this->request->getPost('periodoAtencionDesde');
                $fechaVencimiento = TipoFecha::sumarDiasAlDate($cantidadDiasConfirmacion, $periodoSolicitudHasta);

                if ($fechaVencimiento < $periodoDiaAtencion) {
                    $fechasTurnos = new Fechasturnos();
                    $fechasTurnos->assign(array(
                        'fechasTurnos_inicioSolicitud' => $this->request->getPost('periodoSolicitudDesde'),
                        'fechasTurnos_finSolicitud' => $periodoSolicitudHasta,
                        'fechasTurnos_diaAtencion' => $periodoDiaAtencion,
                        'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('cantidadTurnos', 'int'),
                        'fechasTurnos_cantidadAutorizados' => 0,
                        'fechasTurnos_cantidadDiasConfirmacion' => $cantidadDiasConfirmacion,
                        'fechasTurnos_activo' => 1,
                        'fechasTurnos_sinTurnos' => 1,
                    ));

                    if ($fechasTurnos->save()) {
                        //Si ya habia un periodo, lo desactivamos.
                        if ($fechasTurnos->fechasTurnos_id > 1) {
                            $id = $fechasTurnos->fechasTurnos_id - 1;
                            $phql = "UPDATE Fechasturnos SET fechasTurnos_activo=0 WHERE fechasTurnos_id = :id:";
                            $this->modelsManager->executeQuery($phql, array('id' => $id));
                        }

                        //-----------------------------------------------------
                        //Creo un nuevo schedule
                        $puntoProgramado = \Modules\Models\Schedule::crearSchedule('plazo', 'Vencimiento de Periodo', $this->request->getPost('periodoSolicitudDesde'), $periodoSolicitudHasta);
                        if (!$puntoProgramado) {
                            $this->flash->message('problema', 'Surgió un problema al insertar un nuevo punto programado.');
                        }
                        //-----------------------------------------------------

                        $this->flash->message('exito', 'La configuración de las fechas se ha realizado satisfactoriamente.');
                        $periodoSolicitudForm->clear();
                    }
                    $this->flash->error($fechasTurnos->getMessages());
                } else {

                    $this->flash->message('problema', "La <strong>Fecha de Vencimiento</strong> para confirmar el email ( $fechaVencimiento )  supera la <strong>fecha de Atencion</strong>. <br> Decremente la <ins>cantidad de días</ins> para confirmar los turnos o cambie la fecha de atención de turnos. ");
                }

            }
        }
    }

    /**
     * Encargado de dehabilitar un periodo. Por lo general se deshabilitan automaticamente, pero tambien se
     * podrá realizar manualmente.
     */
    public function deshabilitarAction($idPeriodo)
    {

        $periodo = Fechasturnos::findFirstByFechasTurnos_id($idPeriodo);
        $periodo->fechasTurnos_activo = 0;
        if ($periodo->update()) {
            $schedule = $this->getDi()->get('schedule');
            $puntoProgramado = $schedule->getByType('plazo')->getLast();
            $puntoProgramado->setEnd('00-00-0000');
            if ($puntoProgramado->update())
                $this->flash->success("EL PERIODO SE HA DESHABILITADO CORRECTAMENTE");
        } else
            $this->flash->error("NO SE HA PODIDO DESHABILITAR EL PERIODO, INFORMAR AL SOPORTE TECNICO.");
        $this->redireccionar('turnos/verPeriodos');
    }

    /**
     * Muestra una grilla paginada con los datos de los afiliados que solicitaron turnos.
     *
     *
     */
    public function turnosSolicitadosAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        //FIXME:Controlar periodo
        if (!empty($ultimoPeriodo)) {
            $fechaInicio = $ultimoPeriodo->fechasTurnos_inicioSolicitud;
            $fechaFin = $ultimoPeriodo->fechasTurnos_finSolicitud;

            $this->view->fechaInicial = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
            $this->view->fechaFinal = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
            $this->view->diaAtencion = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
            $this->view->turnosAutorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
            $this->view->cantidadDeTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
            $this->view->autorizadosEnviados = $this->cantRtasAutorizadasEnviadas();
        } else {
            $fechaInicio = '-';
            $fechaFin = '-';
            $this->view->fechaInicial = '-';
            $this->view->fechaFinal = '-';
            $this->view->diaAtencion = '-';
            $this->view->turnosAutorizados = '-';
            $this->view->cantidadDeTurnos = '-';
            $this->view->autorizadosEnviados = '-';
            $this->flash->message('problema', 'NO HAY NINGÚN PERIODO HABILITADO PARA SOLICITAR TURNOS.');
        }

        $solicitudes = $this->modelsManager->createBuilder()
            ->addFrom('Solicitudturno', 'S')
            ->join('Fechasturnos', 'S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ', 'F')
            ->where(" F.fechasTurnos_activo=1 AND S.solicitudTurno_manual = 0 and (S.solicitudTurno_fechaPedido between :fI: and :fF:) and S.solicitudTurno_respuestaEnviada='NO'",
                array('fI' => $fechaInicio, 'fF' => $fechaFin))
            ->orderBy('S.solicitudTurno_fechaPedido ASC');


        $paginator = new PaginacionBuilder
        (
            array
            (
                "builder" => $solicitudes,
                "limit" => 10,
                "page" => $this->request->getQuery('page', 'int')
            )
        );
        $this->view->page = $paginator->getPaginate();

        //$this->view->formularioSimple = new EditarSolicitudTurnoForm();
        //$this->view->formulario = new EditarSolicitudTurnoForm(null,array('revision'=>'true'));
    }

    /**
     * @desc - permitimos editar la informacion del prestamo. AJAX
     * @return json
     */
    public function editAction()
    {
        //deshabilitamos la vista para peticiones ajax
        $data = array();

        $this->view->disable();
        if ($this->request->isPost()) {
            //si es una petición ajax
            if ($this->request->isAjax()) {
                //si existe el token del formulario y es correcto(evita csrf)
                $solicitudTurno = Solicitudturno::findFirstBySolicitudTurno_id($this->request->getPost('solicitudTurno_id'));
                $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);

                if ($solicitudTurno) {
                    $estadoAntiguo = $solicitudTurno->solicitudTurno_estado;
                    $estadoNuevo = $this->request->getPost('solicitudTurno_estado');

                    //Actualizando la instancia de solicitudTurno
                    $solicitudTurno->solicitudTurno_estado = $estadoNuevo;

                    if ($estadoAntiguo == 'DENEGADO POR FALTA DE TURNOS' && $estadoNuevo == 'AUTORIZADO') //modif(nov/2015)
                    {
                        if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos == $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                            $data['CANTIDAD'] = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
                            $data['AUTORIZADO'] = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
                            $solicitudTurno->solicitudTurno_estado = 'DENEGADO POR FALTA DE TURNOS';
                            $solicitudTurno->solicitudTurno_montoMax = 0;
                            $solicitudTurno->solicitudTurno_montoPosible = 0;
                            $solicitudTurno->solicitudTurno_cantCuotas = 0;
                            $solicitudTurno->solicitudTurno_valorCuota = 0;
                            $solicitudTurno->solicitudTurno_observaciones = '-';
                            $solicitudTurno->solicitudTurno_nickUsuario = $this->session->get('auth')['usuario_nick'];
                            $solicitudTurno->solicitudTurno_fechaProcesamiento = Date('y-m-d');
                        } else {
                            Fechasturnos::incrementarCantAutorizados();
                            $solicitudTurno->solicitudTurno_montoMax = $this->request->getPost('solicitudTurno_montoMax', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_montoPosible = $this->request->getPost('solicitudTurno_montoPosible', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_cantCuotas = $this->request->getPost('solicitudTurno_cantCuotas', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_valorCuota = $this->request->getPost('solicitudTurno_valorCuota', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_observaciones = $this->request->getPost('solicitudTurno_observaciones', array('string'));
                            $solicitudTurno->solicitudTurno_nickUsuario = $this->session->get('auth')['usuario_nick'];
                            $solicitudTurno->solicitudTurno_fechaProcesamiento = Date('y-m-d');
                        }
                    } else {
                        //Si deja de estar autorizado se decrementa.
                        if ($estadoAntiguo == "AUTORIZADO" && $estadoNuevo != "AUTORIZADO")
                            Fechasturnos::decrementarCantAutorizados();
                        else //Si se autoriza se incrementa.
                        {
                            if ($estadoAntiguo != "AUTORIZADO" && $estadoNuevo == "AUTORIZADO")
                                Fechasturnos::incrementarCantAutorizados();
                        }

                        //Verificamos si se puede editar todos los campos.
                        //if ($this->request->getPost('editable') == 1) {
                        if ($estadoNuevo == "REVISION" || $estadoNuevo == "AUTORIZADO") {
                            $solicitudTurno->solicitudTurno_montoMax = $this->request->getPost('solicitudTurno_montoMax', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_montoPosible = $this->request->getPost('solicitudTurno_montoPosible', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_cantCuotas = $this->request->getPost('solicitudTurno_cantCuotas', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_valorCuota = $this->request->getPost('solicitudTurno_valorCuota', array('int', 'trim'));
                            $solicitudTurno->solicitudTurno_observaciones = $this->request->getPost('solicitudTurno_observaciones', array('string'));
                            $solicitudTurno->solicitudTurno_nickUsuario = $this->session->get('auth')['usuario_nick'];
                            $solicitudTurno->solicitudTurno_fechaProcesamiento = Date('y-m-d');
                        } else {
                            $solicitudTurno->solicitudTurno_montoMax = 0;
                            $solicitudTurno->solicitudTurno_montoPosible = 0;
                            $solicitudTurno->solicitudTurno_cantCuotas = 0;
                            $solicitudTurno->solicitudTurno_valorCuota = 0;

                            if ($estadoNuevo == "DENEGADO")
                                $solicitudTurno->solicitudTurno_observaciones = $this->request->getPost('causa');
                            else
                                $solicitudTurno->solicitudTurno_observaciones = "-";

                            $solicitudTurno->solicitudTurno_nickUsuario = $this->session->get('auth')['usuario_nick'];
                            $solicitudTurno->solicitudTurno_fechaProcesamiento = Date('y-m-d');
                        }
                    }

                    if ($solicitudTurno->update()) {
                        $this->response->setJsonContent(array("res" => "success", "datos" => $data));
                        $this->response->setStatusCode(200, "OK");
                    } else {
                    }
                } else {
                    $this->response->setJsonContent(array("res" => "warning"));
                    $this->response->setStatusCode(500, "Ocurrio un error, no se pudieron guardar los datos. Comunicarse con Soporte Tecnico.");
                }
                $this->response->send();
            }
        }
    }

    public function turnosRespondidosAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        //FIXME:
        if (!empty($ultimoPeriodo)) {
            $this->view->fechaI = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
            $this->view->fechaF = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
            $this->view->diaA = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
            $this->view->cantA = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
            $this->view->cantidadDeTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
        } else {
            $this->view->fechaI = '-';
            $this->view->fechaF = '-';
            $this->view->diaA = '-';
            $this->view->cantA = '-';
            $this->view->cantidadDeTurnos = '-';
            $this->flash->message('problema', 'NO HAY NINGÚN PERIODO HABILITADO PARA SOLICITAR TURNOS.');
        }

        $paginator = new PaginatorArray
        (
            array(
                "data" => Solicitudturno::accionVerSolicitudesConRespuestaEnviada(),
                "limit" => 10,
                "page" => $this->request->getQuery('page', 'int')
            )
        );

        $this->view->page = $paginator->getPaginate();

    }

    public function cantRtasAutorizadasEnviadas()
    {
        try {
            $cant = 0;
            $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo.
            $fI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $fF = $fechaTurnos->fechasTurnos_finSolicitud;

            $sql = "SELECT count(*) as cantidad FROM solicitudturno WHERE (DATE(solicitudTurno_fechaPedido) BETWEEN '$fI' and '$fF'
                     and solicitudTurno_respuestaEnviada='SI' and solicitudTurno_estado='AUTORIZADO')";
            $result = $this->db->query($sql);

            if ($result->numRows() != 0) {
                $respuesta = $result->fetch();
                $cant = $respuesta['cantidad'];
            }
        } catch (Phalcon\Db\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
        }
        return $cant;
    }

    public function vueltaAction()
    {
        //no hace nada, esta solo para que vaya a la vista.
    }


    /*==================================================================================================================*/
    /*                                        ENVIAR TODAS LAS RESPUESTAS                                               */
    /*==================================================================================================================*/
    /**
     * Envia el correo segun el estado en el que se encuentra sera el mensaje enviado.
     * Si es una solicitud Personal se generará un numero de comprobante pero no se enviara ningun correo.
     */
    public function enviarRespuestasAction()
    {
        $usuarioActual = $this->session->get('auth')['usuario_nick'];
        $solicitudesAutorizadas = Solicitudturno::recuperaSolicitudesSegunEstado('AUTORIZADO', $usuarioActual);
        $solicitudesDenegadas = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO', $usuarioActual);
        $solicitudesDenegadasFaltaTurnos = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO POR FALTA DE TURNOS', $usuarioActual);

        if (count($solicitudesAutorizadas) == 0 && count($solicitudesDenegadas) == 0 && count($solicitudesDenegadasFaltaTurnos) == 0) {
            $this->flash->message('', "<div><h3>No se pueden enviar respuestas,<br> ya que solo hay solicitudes pendientes o en revisión.</h3></div>");
        } else {
            $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
            $fechaAtencion = TipoFecha::fechaEnLetras($ultimoPeriodo->fechasTurnos_diaAtencion);//date('d-m-Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));

            $textoA = "En respuesta a su solicitud, le comunicamos que podrá dirigirse a nuestra institución el día " . $fechaAtencion . " para <b>trámitar</b> un préstamo personal.";
            $textoDxFdT = "En respuesta a su solicitud, le comunicamos que no es posible otorgarle un turno para trámitar un préstamo personal porque todos los turnos disponibles para este mes ya fueron dados.";
            $textoD = "En respuesta a su solicitud, le comunicamos que no es posible otorgarle un turno para trámitar un préstamo personal porque ";

            if (count($solicitudesAutorizadas) != 0)
                $this->envioRespuestas($solicitudesAutorizadas, $textoA, 'A', $ultimoPeriodo);

            if (count($solicitudesDenegadas) != 0)
                $this->envioRespuestas($solicitudesDenegadas, $textoD, 'D');

            if (count($solicitudesDenegadasFaltaTurnos) != 0)
                $this->envioRespuestas($solicitudesDenegadasFaltaTurnos, $textoDxFdT, 'DFT');
            $this->flash->message('', '<div><h1>Las respuestas fueron enviadas a los afiliados. </h1></div>');
        }

    }

    private function envioRespuestas($solicitudes, $texto, $tipoEstado, $ultimoPeriodo = null)
    {
        foreach ($solicitudes as $unaSolicitud) {
            if ($unaSolicitud['solicitudTurno_tipo'] == 2) {
                $actualizarSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($unaSolicitud['solicitudTurno_id']);
                if ($tipoEstado == 'A' && $ultimoPeriodo->fechasTurnos_sinTurnos == 1) {
                    $actualizarSolicitud->solicitudTurno_numero = 1;
                    $ultimoPeriodo->fechasTurnos_sinTurnos = 0;
                    if (!$ultimoPeriodo->update() || $unaSolicitud->update())
                        $this->flash->error('OCURRIO UN ERROR AL GENERAR EL Nº DE TURNO. INTENTELO NUEVAMENTE.');
                } else {
                    $nroTurno = Solicitudturno::getUltimoTurnoDelPeriodo() + 1;
                    $actualizarSolicitud->solicitudTurno_numero = $nroTurno;
                    if (!$actualizarSolicitud->update())
                        $this->flash->error('OCURRIO UN ERROR AL GENERAR EL Nº DE TURNO. INTENTELO NUEVAMENTE.');
                }

            } else
                $this->enviarEmail($unaSolicitud, $texto, $tipoEstado);
        }
    }

    private function enviarEmail($unaSolicitud, $mensaje, $tipoEstado)
    {
        if ($unaSolicitud['solicitudTurno_email'] != "") {
            $unPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
            $diasConfirmacion = $unPeriodo->fechasTurnos_cantidadDiasConfirmacion;

            $idSol = $unaSolicitud['solicitudTurno_id'];
            $correo = $unaSolicitud['solicitudTurno_email'];
            $nomApe = $unaSolicitud['solicitudTurno_nomApe'];
            $montoM = $unaSolicitud['solicitudTurno_montoMax'];
            $montoP = $unaSolicitud['solicitudTurno_montoPosible'];
            $cantCuotas = $unaSolicitud['solicitudTurno_cantCuotas'];
            $valorCuota = $unaSolicitud['solicitudTurno_valorCuota'];
            $obs = $unaSolicitud['solicitudTurno_observaciones'];

            $this->mailDesarrollo->CharSet = 'UTF-8';
            $this->mailDesarrollo->Host = 'mail.imps.org.ar';
            $this->mailDesarrollo->SMTPAuth = true;
            $this->mailDesarrollo->Username = 'desarrollo@imps.org.ar';
            $this->mailDesarrollo->Password = 'sis$%&--temas';
            $this->mailDesarrollo->SMTPSecure = '';
            $this->mailDesarrollo->Port = 26;
            $this->mailDesarrollo->From = 'desarrollo@imps.org.ar';
            $this->mailDesarrollo->FromName = 'IMPS - DIVISIÓN AFILIADOS';

            $this->mailDesarrollo->addAddress($correo, $nomApe);
            $this->mailDesarrollo->Subject = "Respuesta por solicitud de un turno en IMPS.";

            $idCodif = base64_encode($idSol);

            $texto = "Estimado/a  " . $nomApe . ":<br/> <br/>" . $mensaje;
            $textoFinal = "Para confirmar que recibio este mensaje, "
                . " <a href='http://localhost/impsweb/turnos/confirmaEmail/?id=" . $idCodif . "' target='_blank'>haga click aquí.</a>"
                . "<br/><br/> Saluda atte.,<br/> Instituto Municipal de Previsión Social <br/> Fotheringham 277 - Neuquén Capital. <br/> Teléfono: (0299) 4433798"
                . "<br/><br/> <p style='color:gray;'>Por favor no responda a esta dirección de correo. Si desea realizar alguna consulta podrá dirijirse a nuestras oficinas o "
                . "<a href='http://imps.org.ar/impsweb/' target='_blank'>hacer click aquí.</a></p>";

            if ($tipoEstado == 'A') {
                $cad1 = "Además, a modo informativo, le avisamos que el monto máximo que se le puede prestar es $" . $montoM . ", el monto posible que se le puede otorgar es $" . $montoP;
                $cadena = $cad1 . ", la cantidad máxima de cuotas es " . $cantCuotas . " y el valor de cada una de ellas es de $" . $valorCuota . '.<br/>';

                if ($obs != '-' && $obs != '')
                    $cadena .= "Nota: " . $obs . "<br/>";

                $cadena .= "Recuerde que usted tiene " . $diasConfirmacion . " días para confirmar el mensaje, de lo contrario el turno será cancelado.<br/>";

                $this->mailDesarrollo->Body = $texto . '<br/>' . $cadena . $textoFinal;
            } else {
                if ($tipoEstado == 'D')
                    $this->mailDesarrollo->Body = $texto . ' ' . strtolower($obs) . '.<br/>' . $textoFinal;
                else {
                    if ($obs != '-' && $obs != '')
                        $texto .= "Nota: " . $obs . "<br/>";

                    $this->mailDesarrollo->Body = $texto . '<br/>' . $textoFinal;
                }
            }

            $send = $this->mailDesarrollo->send();
        }
    }

    /**
     * El afiliado ingresa al link enviado por email y se redirecciona a esta accion, el cual está
     * encargado de controlar que la confirmacion del afiliado se realice dentro de los dias establecidos.
     * En caso de que haya vencido o no el plazo se le mostrara un cartel al usuario informandolo.
     * Si inicioSolicitud+cantidadDiaConfirmacion < hoy => ya venció el plazo.
     * Si inicioSolicitud+cantidadDiaConfirmacion > hoy => está dentro del plazo de confirmación.
     */
    public function confirmaEmailAction()
    {
        $idSolicitud = $this->request->get('id');
        $id = base64_decode($idSolicitud);
        $laSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);

        if (!empty($laSolicitud)) {
            $estado = $laSolicitud->solicitudTurno_estado;

            if ($estado == 'AUTORIZADO') {
                $resultado = $laSolicitud->comprobarRespuesta();

                if ($resultado['vencido'] == 2) {
                    $this->flash->message("", "<h1>LAMENTABLEMENTE EL PLAZO DE CONFIRMACIÓN HA FINALIZADO, POR FAVOR VUELVA A SOLICITAR EL TURNO.</h1>");
                } else {
                    // $resultado['nroTurno] es igual a $laSolicitud->solicitudTurno_numero;
                    if ($resultado['vencido'] == 1) {
                        $this->flash->message("", "<h1> GRACIAS POR SU CONFIRMACIÓN </h1>
                                            <h3 class='login-title'> EL TURNO ES EL Nº " . $resultado['nroTurno'] . "</h3>
                                            <h3>" . $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idSolicitud, 'IMPRIMIR COMPROBANTE DE TURNO',
                                'class' => 'btn btn-info btn-large', 'target' => '_blank')) . "</h3>");
                    } else {
                        $boton = $this->tag->form(array('turnos/comprobanteTurnoPost', 'method' => 'POST'));
                        $encode = base64_encode($laSolicitud->solicitudTurno_id);
                        $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $encode));
                        $boton .= "<button type='submit' class='btn btn-info btn-lg' formtarget='_blank'><i class='fa fa-print'></i> IMPRIMIR COMPROBANTE DE TURNO</button>";
                        $boton .= "</form>";
                        $this->flash->message("", "<h1> USTED YA HA CONFIRMADO EL TURNO </h1>
                                            <h3 class='login-title'> EL TURNO ES EL Nº " . $resultado['nroTurno'] . "</h3><hr>");
                        $this->flash->notice($boton);
                        //antes estaba $laSolicitud->solicitudTurno_id en vez de $idSolicitud
                    }
                }

                $this->view->vencido = $resultado['vencido'];
                $this->view->nroTurno = $resultado['nroTurno'];
            } else {
                Solicitudturno::cambiarRespuesta($id);
                $this->flash->message("", "<h1> GRACIAS POR CONFIRMAR EL RECIBO DEL MENSAJE.</h1>");
            }
        } else
            $this->redireccionar('index/index');
    }
    /*==================================================================================================================*/
    /*                                        GENERAR COMPROBANTE                                                       */
    /*==================================================================================================================*/
    /**
     * Se utiliza para generar un comprobante pdf, los empleados de imps unicamente pueden utilizar este metodo.
     * @param $idSolicitud
     */
    public function comprobanteTurnoAction()
    {
        $idSolicitud = $this->request->get('id');
        //echo  $this->request->get('id') ." --- ". $id = base64_decode($idSolicitud); ;
        //$this->view->pick('turnos/turnosRespondidos');

        $idSolicitud = $this->request->get('id');
        $id = base64_decode($idSolicitud);
        $solicitud = Solicitudturno::findFirstBySolicitudTurno_id($id);

        if (!$solicitud)
            $mensaje = "ERROR";
        else
            $mensaje = 'EXITO';

        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
        $this->view->disable();
        $html = $this->view->getRender('turnos', 'comprobanteTurno', array('solicitud' => $solicitud, 'mensaje' => $mensaje));
        $pdf = new mPDF();
        $pdf->SetHeader(date('d/m/Y'));
        $pdf->WriteHTML($html, 2);
        $pdf->Output('comprobanteTurno.pdf', "I");


    }

    /**
     * Genera el comprobante de turno en pdf mediante post. Se utiliza para el public en general.
     */
    public function comprobanteTurnoPostAction()
    {
        if (!$this->request->isPost()) {
            $this->flash->error("Ocurrió un problema, la URL solicitada no se encuentra disponible.");
            $this->redireccionar('index/index');
        }
        $idSolicitud = base64_decode($this->request->getPost('solicitud_id'));
        $solicitud = Solicitudturno::findFirstBySolicitudTurno_id($idSolicitud);

        if (empty($solicitud))
            $mensaje = "ERROR";
        else
            $mensaje = 'EXITO';

        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
        $this->view->disable();
        $html = $this->view->getRender('turnos', 'comprobanteTurno', array('solicitud' => $solicitud, 'mensaje' => $mensaje));
        $pdf = new mPDF();
        $pdf->SetHeader(date('d/m/Y'));
        $pdf->WriteHTML($html, 2);
        $pdf->Output('comprobanteTurno.pdf', "I");
    }
    /*==================================================================================================================*/
    /*                                       LISTADO PDF                                                       */
    /*==================================================================================================================*/
    public function listadoEnPdfAction()
    {
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes // si funciona pero la pagina anterior se corrompe

        $listado = Solicitudturno::accionVerSolicitudesConRespuestaEnviada();
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        $fechaInicio = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
        $fechaFin = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
        $diaAtencion = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
        $cantTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
        $cantAut = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;

        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.

        //GENERAR PDF
        $this->view->disable();
        // Get the view data
        $html = $this->view->getRender('turnos', 'listadoEnPdf', array('listado' => $listado, 'fechaI' => $fechaInicio, 'fechaF' => $fechaFin, 'diaA' => $diaAtencion, 'cantAut' => $cantAut, 'cantTurnos' => $cantTurnos));
        $pdf = new mPDF();

        $pdf->SetHeader(date('d/m/Y'));

        $pdf->pagenumPrefix = 'P&aacute;gina ';
        $pdf->nbpgPrefix = ' de ';
        $pdf->setFooter('{PAGENO}{nbpg}');

        //$pdf->setFooter('P&aacute;gina'.' {PAGENO}');
        //$pdf->ignore_invalid_utf8 = true;

        $pdf->WriteHTML($html);
        $pdf->Output('listadoDeSolicitudes.pdf', "I"); //I:Es la opción por defecto, y lanza el archivo a que sea abierto en el navegador.
    }
    /*==================================================================================================================*/
    /*                                        PERIODO                                                                  */
    /*==================================================================================================================*/
    /**
     * Muestra una grilla con todos los periodos y permite la edicion de los campos:
     * fechasTurnos_cantidadDeTurnos
     * fechasTurnos_diaAtencion
     */
    public function verPeriodosAction()
    {
        //Crea un paginador, muestra 3 filas por página
        $paginator = new Paginacion(
            array(
                //obtenemos los productos
                "data" => Fechasturnos::find(array(
                    "order" => "fechasTurnos_id DESC"
                )),
                //limite por página
                "limit" => 10,
                //variable get page convertida en un integer
                "page" => $this->request->getQuery('page', 'int')
            )
        );

        //pasamos el objeto a la vista con el nombre de $page
        $this->view->tabla = $paginator->getPaginate();
    }

    /**
     * Muestra un formulario con el periodo a editar.
     * @param $idFechaTurno
     */
    public function editarPeriodoAction($idFechaTurno)
    {
        $unaFechaTurno = Fechasturnos::findFirstByFechasTurnos_id($idFechaTurno);
        $this->view->formulario = new EditarPeriodoForm($unaFechaTurno);
        $this->view->idPeriodo = $idFechaTurno;
    }

    /**
     * Guarda los datos editados del periodo. Update.
     * @return null
     */
    public function guardarDatosEdicionPeriodoAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('idPeriodo', 'int');
            $unPeriodo = Fechasturnos::findFirstByFechasTurnos_id($id);
            if ($unPeriodo) {
                $unPeriodo->fechasTurnos_inicioSolicitud = $this->request->getPost('periodoSolicitudDesde');
                $unPeriodo->fechasTurnos_finSolicitud = $this->request->getPost('periodoSolicitudHasta');
                $unPeriodo->fechasTrnos_diaAtencion = $this->request->getPost('periodoAtencionDesde');
                $unPeriodo->fechasTurnos_cantidadDeTurnos = $this->request->getPost('cantidadTurnos');
                $unPeriodo->fechasTurnos_cantidadDiasConfirmacion = $this->request->getPost('cantidadDias');
                $unPeriodo->fechasTurnos_activo = 1;
                if ($unPeriodo->update()) {
                    $schedule = $this->getDi()->get('schedule');
                    $puntoProgramado = $schedule->getByType('plazo')->getLast();
                    $puntoProgramado->setStart($this->request->getPost('periodoSolicitudDesde'));
                    $new_time = date('Y-m-d H:i:s', strtotime($this->request->getPost('periodoSolicitudHasta')) + 82800);//Le seteo a la fecha final las 23:00:00
                    $puntoProgramado->setEnd($new_time);
                    if ($puntoProgramado->update())
                        $this->flash->message('exito', "Los datos se guardaron correctamente!");

                } else {
                    $this->flash->message('problema', "Ocurrio un error, no se pudieron guardar los datos.");
                }
            } else {
                $this->flash->message('problema', "NO SE ENCONTRÓ EL PERIODO A EDITAR");
            }
        } else
            $this->flash->message('problema', "NO ES POST");
        return $this->redireccionar('turnos/verPeriodos');
    }
    /*==================================================================================================================*/
    /*                                        SOLICITUD PERSONAL                                                        */
    /*==================================================================================================================*/

    /**
     * Utilizado para que los afiliados puedan solicitar turnos personalmente.
     * 1. Controlamos que haya un periodo activo.
     * 2. Enviamos el Formulario a la vista.
     * 3.
     */
    public function solicitudPersonalAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if ($ultimoPeriodo) {
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos > $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $info = array();
                $info['cantidadAutorizados'] = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
                $info['cantidadTurnos'] = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
                $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
                $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
                $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
                $this->view->informacion = $info;
                $turnosOnlineForm = new TurnoForm(null, array('tipo' => 'personal'));
                $this->view->formulario = $turnosOnlineForm;
            } else {
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
                return $this->redireccionar('administrar/index');
            }

        } else {
            $this->flash->error("EL PERIODO PARA SOLICITAR TURNOS NO SE ENCUENTRA DISPONIBLE.");
            return $this->redireccionar('administrar/index');

        }
    }

    public function guardarSolicitudPersonalAction()
    {

        if (!$this->request->isPost()) {
            $this->response->redirect('index/index');
        }
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if ($ultimoPeriodo) {

            /*================== Controlo la cantidad de turnos ========================*/
            if ($ultimoPeriodo->fechasTurnos_cantidadDeTurnos <= $ultimoPeriodo->fechasTurnos_cantidadAutorizados) {
                $this->flash->error("LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES.");
                return $this->redireccionar('administrar/index');
            }
            /* ============================== Control de Post =================================== */
            if (!$this->request->hasPost('solicitudTurno_legajo') || $this->request->getPost('solicitudTurno_legajo', array('trim', 'int')) == "") {
                $this->flash->error('Ingrese el Legajo');
                return $this->redireccionar('turnos/solicitudPersonal');
            }
            if (!$this->request->hasPost('solicitudTurno_documento') || $this->request->getPost('solicitudTurno_documento', array('trim', 'int')) == "") {
                $this->flash->error('Ingrese el Documento');
                return $this->redireccionar('turnos/solicitudPersonal');
            }
            /* ==================================================================================== */
            $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
            $documento = $this->request->getPost('solicitudTurno_documento', array('int', 'trim'));
            $afiliado = $this->buscarAfiliadoEnSiprea($legajo);
            if ($afiliado == NULL) {
                $this->flash->error("USTED NO SE ENCUENTRA REGISTRADO COMO UN AFILIADO ACTIVO.");
                return $this->redireccionar('turnos/solicitudPersonal');
            }
            if ($this->tieneTurnoSolicitado($afiliado["afiliado_legajo"], $afiliado["afiliado_apenom"])) {
                $this->flash->error("USTED YA SOLICITO UN TURNO, NO ES POSIBLE OBTENER MÁS DE UN TURNO POR PERIODO.");
                return $this->redireccionar('turnos/solicitudPersonal');
            }
            $guardado = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $afiliado["afiliado_apenom"], $documento,
                "", "", $ultimoPeriodo->fechasTurnos_id, 2);
            if (!$guardado) {
                $this->flash->error('HA OCURRIDO UN ERROR AL GUARDAR LOS DATOS, VERIFIQUE QUE LOS DATOS INGRESADOS SEAN CORRECTOS.');
                return $this->redireccionar('turnos/solicitudPersonal');
            }
            $this->flash->success('OPERACIÓN EXITOSA, POR FAVOR ESPERE A SER ATENDIDO.');
            //Imprimir comprobante.
        } else {
            $this->flash->error("EL PERIODO PARA SOLICITAR TURNOS NO SE ENCUENTRA DISPONIBLE.");
            return $this->redireccionar('administrar/index');
        }
        $this->redireccionar('turnos/solicitudPersonal');
    }

    private function buscarAfiliadoEnSiprea($legajo)
    {
        try {
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom, AF.afiliado_apenom FROM siprea2.afiliados AS AF
                      WHERE (AF.afiliado_legajo LIKE '%" . $legajo . "%') AND (AF.afiliado_activo = 1);";
            $result = $this->dbSiprea->query($sql);

            if ($result->numRows() != 0) {
                $afiliados = $result->fetch();
                return $afiliados;
            }
            return NULL;

        } catch (Phalcon\Db\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
        }
        return "";
    }

    /**
     * Explica como funciona el sistema de turnos.
     */
    public function presentacionAction()
    {

    }

    /**
     * Muestra un calendario con los periodos disponibles.
     * @return string
     */
    public function calendarioAction()
    {
        $this->tag->setTitle('Calendario');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('headerCss')->addJs("plugins/calendario/calendar.css");
        $this->assets->collection('footer')->addJs("plugins/calendario/calendar.js");
        $rangoJs="";
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if($ultimoPeriodo){
           $fechas = TipoFecha::devolverTodosLosDiasEntreFechas($ultimoPeriodo->fechasTurnos_inicioSolicitud,$ultimoPeriodo->fechasTurnos_finSolicitud);
            $rangoJs = "[";
            foreach($fechas as $dia){
                $rangoJs .="{date:'$dia','value':'Periodo para solicitar Turno'},";
            }
            $rangoJs .="]";
        }else
            return $this->flash->error("NO HAY NINGUN PERIODO DISPONIBLE");
        if($rangoJs=="")
            return $this->flash->error("NO HAY NINGUN PERIODO DISPONIBLE");

        $this->assets->collection('footerInline')->addInlineJs("$('#ca').calendar({
                    // view: 'month',
                    width: 320,
                    height: 320,
                    // startWeek: 0,
                    // selectedRang: [new Date(), null],
                    data: $rangoJs,
                            onSelected: function (view, date, data) {
                                console.log('view:' + view)
                                console.log('date:' + date)
                                console.log('data:' + (data || 'None'));
                            }
                        });

                        $('#dd').calendar({
                            trigger: '#dt',
                            // offset: [0, 1],
                            zIndex: 999,
                            onSelected: function (view, date, data) {
                                console.log('event: onSelected')
                            },
                            onClose: function (view, date, data) {
                                console.log('event: onClose')
                                console.log('view:' + view)
                                console.log('date:' + date)
                                console.log('data:' + (data || 'None'));
                            }
                        });
                      var _gaq = _gaq || [];
                      _gaq.push(['_setAccount', 'UA-36251023-1']);
                      _gaq.push(['_setDomainName', 'jqueryscript.net']);
                      _gaq.push(['_trackPageview']);

                      (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                      })();
                    ");
    }

    /**
     * Solicita legajo y codigo de operacion para Cancelar el turno solicitado.
     */
    public function cancelarTurnoAction()
    {
        $this->tag->setTitle('Cancelar Turno');
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if (!$ultimoPeriodo) {
            $this->flash->error("EL PERIODO PARA CANCELAR LOS TURNOS NO SE ENCUENTRA HABILITADO.");
            $this->view->deshabilitar = true;
        }
        $this->assets->collection('footerInline')->addInlineJs("  $(document).ready(function(){
            $('[data-toggle=\"tooltip\"]').tooltip();
        });");

    }

    /**
     * Busca el turno solicitado y lo deshabilita, lo que conlleva:
     * - Liberar un turno: fechasTurnos_sinTurnos = 0 , fechasTurnos_cantidadAutorizados --
     * @return null
     */
    public function liberarTurnoAction(){
        if(!$this->request->isPost()){
            return $this->redireccionar('turnos/cancelarTurno');
        }

        if(!$this->request->hasPost('legajo') || $this->request->getPost('legajo','int')==null){
            $this->flash->error('INGRESE EL LEGAJO');
        }

        if(!$this->request->hasPost('codigo') || $this->request->getPost('codigo','alphanum')==null){
            $this->flash->error('INGRESE EL CODIGO');
        }
        $legajo = $this->request->getPost('legajo','int');
        $codigo = $this->request->getPost('codigo','alphanum');
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_legajo=:legajo: AND solicitudTurno_codigo=:codigo: AND solicitudTurno_habilitado=1',
            'bind'=>array('legajo'=>$legajo,'codigo'=>$codigo)));
        if(!$solicitudTurno)
        {
            $this->flash->error('NO SE HA ENCONTRADO EL TURNO ASOCIADO CON LOS DATOS INGRESADO');
            return $this->redireccionar('turnos/cancelarTurno');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo = 1 AND fechasTurnos_id=:id:',
            'bind'=>array('id'=>$solicitudTurno->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $this->flash->error("EL PERIODO PARA CANCELAR LOS TURNOS HA FINALIZADO.");
            return $this->redireccionar('turnos/cancelarTurno');
        }
        $this->db->begin();
        $solicitudTurno->setSolicitudturnoHabilitado(0);
        if(!$solicitudTurno->update())
        {
            $this->flash->error('Ocurrio un problema al deshabilitar el turno');
            $this->db->rollback();
            return $this->redireccionar('turnos/cancelarTurno');
        }
        $ultimoPeriodo->setFechasturnosCantidadautorizados($ultimoPeriodo->getFechasturnosCantidadautorizados()-1);
        $ultimoPeriodo->setFechasturnosSinturnos(0);//No hace falta preguntar si esta en 0 o en 1.
        if(!$ultimoPeriodo->update()){
            $this->flash->error('Ocurrio un problema al deshabilitar el turno. Periodo no actualizado.');
            $this->db->rollback();
            return $this->redireccionar('turnos/cancelarTurno');
        }
        $this->db->commit();
        $this->flash->success("Operación Exitosa: El turno se ha cancelado.");
        $this->redireccionar('turnos/canelarTurno');


    }

}



