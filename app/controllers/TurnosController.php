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
    /**
     * Muestra el formulario para solicitar turno.
     * 1. valida sus campos.
     * 2. valida si esta dentro del periodo disponible para solicitar turnos.
     * 3. verifica si los datos ingresados pertenecen a un afiliado de siprea y verifica si hay cupos disponibles
     * 4. verifica que no haya solicitado otro turno en el periodo actual.
     * 5.
     */
    public function indexAction()
    {
        $this->view->setTemplateAfter('admin');
        $turnosOnlineForm = new TurnosOnlineForm();
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        //FIXME:
        if (!empty($ultimoPeriodo)) {

            if ($this->request->isPost()) {
                $data = $this->request->getPost();

                if ($turnosOnlineForm->isValid($data) != false) //aqui es donde valida los datos ingresados
                {
                    $razonNoDisponible = $this->verificarDisponibilidad();

                    if ($razonNoDisponible == "") {
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
                            if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto, $email)) {
                                $seGuardo = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email, $numTelefono);

                                if ($seGuardo)//la solicitud se ingreso con exito.
                                {
                                    $this->flash->success('LA SOLICITUD FUE INGRESADA CORRECTAMENTE');
                                    $turnosOnlineForm->clear();
                                    $this->redireccionar('turnos/turnoSolicitadoExitoso');
                                } else
                                    $this->flash->error('OCURRIO UN PROBLEMA, POR FAVOR VUELVA A INTENTARLO EN UNOS MINUTOS.');
                            } else
                                $this->flash->error('SUS DATOS YA FUERON INGRESADOS, NO PUEDE OBTENER MÁS DE UN TURNO POR PERÍODO');
                        } else
                            $this->flash->error('USTED NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA OBTENER MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.');
                    } else
                        $this->flash->error($razonNoDisponible);
                }
            }
        } else
            $this->flash->message('problema', 'NO EXISTE EL PERIODO PARA SOLICITAR TURNOS.');

        $this->view->formulario = $turnosOnlineForm;
    }

    public function solicitudManualAction()
    {
        $turnoManualForm = new TurnoManualForm();

        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        //FIXME:
        if (!empty($ultimoPeriodo)) {
            $this->view->cantAutorizados = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
            $this->view->cantTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
            $this->view->fechaI = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
            $this->view->fechaF = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
            $this->view->diaA = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));


            if ($this->request->isPost()) {
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
                                $seGuardo = Solicitudturno::accionAgregarUnaSolicitudManual($legajo, $nombreCompleto, $documento, $numTelefono, $estado, $nickActual);

                                if ($seGuardo)//la solicitud se ingreso con exito.
                                {
                                    if ($estado == 'AUTORIZADO')
                                        Fechasturnos::incrementarCantAutorizados();

                                    $turnoManualForm->clear();
                                    $this->flash->success('LA SOLICITUD DE TURNO SE INGRESO CON EXITO.');
                                } else
                                    $this->flash->error('OCURRIO UN ERROR, INTENTE MAS TARDE.');
                            } else
                                $this->flash->error('EL AFILIADO YA SOLICITO UN TURNO, POR LO CUAL NO SE PUEDE INGRESAR ESTA SOLICITUD.');
                        } else
                            $this->flash->error('EL AFILIADO NO ESTA REGISTRADO EN EL SISTEMA O ALGUNO DE LOS DATOS INGRESADOS SON INCORRECTOS.');
                    } else
                        $this->flash->error('NO ES POSIBLE INGRESAR LA SOLICITUD EN LA FECHA ACTUAL. VERIFIQUE EL PERIODO DE SOLICITUD.');
                }
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
    }

    /*   public function guardaDatosSolicitudManualAction()
       {
           $turnoManualForm = new TurnoManualForm();

           if ($this->request->isPost())
           {
               if ($turnoManualForm->isValid($this->request->getPost()) != false) //aqui es donde valida los datos ingresados
               {
                   $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                   $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                   $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                   $documento = $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string'));
                   $numTelefono = $this->request->getPost('solicitudTurno_numTelefono', 'int');
                   $estado = $this->request->getPost('estado');
                   $miSesion = $this->session->get('auth');
                   $nickActual = $miSesion['usuario_nick'];

                   $fechaTurno = Fechasturnos::findFirstByFechasTurnos_activo(1);

                   if ($fechaTurno->fechasTurnos_inicioSolicitud <= date('Y-m-d') && date('Y-m-d')<=$fechaTurno->fechasTurnos_finSolicitud)
                   {
                       $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);

                       if ($nombreCompleto != "")
                       {
                           if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto, null))
                           {
                               $seGuardo = Solicitudturno::accionAgregarUnaSolicitudManual($legajo, $nombreCompleto, $documento, $numTelefono, $estado, $nickActual);

                               if ($seGuardo)//la solicitud se ingreso con exito.
                               {
                                   if ($estado == 'AUTORIZADO')
                                       Fechasturnos::incrementarCantAutorizados();

                                   $turnoManualForm->clear();
                                   $this->flash->success('LA SOLICITUD DE TURNO SE INGRESO CON EXITO.');
                               }
                               else
                                   $this->flash->error('OCURRIO UN ERROR, INTENTE MAS TARDE.');
                           }
                           else
                               $this->flash->error('EL AFILIADO YA SOLICITO UN TURNO, POR LO CUAL NO SE PUEDE INGRESAR ESTA SOLICITUD.');
                       }
                       else
                           $this->flash->error('EL AFILIADO NO ESTA REGISTRADO EN EL SISTEMA O ALGUNO DE LOS DATOS INGRESADOS SON INCORRECTOS.');
                   }
                   else
                       $this->flash->error('NO ES POSIBLE INGRESAR LA SOLICITUD EN LA FECHA ACTUAL. VERIFIQUE EL PERIODO DE SOLICITUD.');
               }
           }
           $this->view->formulario = $turnoManualForm;
       }*/

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

    /**Se encarga de realizar 2 verificaciones:
     * 1. que la fecha de hoy se encuentra entre el periodo ingresado por los supervisores.
     * INICIO <= ACTUAL <= FINAL.
     * 2. Que existan cupos disponibles.
     * @return string muestra un mensaje si hubo problemas
     */
    private function verificarDisponibilidad()
    {
        if (Fechasturnos::count() != 0) {
            $ultimo = (int)Fechasturnos::count() - 1;//Obtengo el ultimo indice
            $fechasTurnos = Fechasturnos::find();//Obtengo todos las instancias de Fechasturnos.
            if ($fechasTurnos[$ultimo]->fechasTurnos_inicioSolicitud <= date('Y-m-d')
                && date('Y-m-d') <= $fechasTurnos[$ultimo]->fechasTurnos_finSolicitud
            )
                if ($fechasTurnos[$ultimo]->fechasTurnos_cantidadDeTurnos == $fechasTurnos[$ultimo]->fechasTurnos_cantidadAutorizados)
                    return "LO SENTIMOS, NO HAY TURNOS DISPONIBLES.";
                else
                    return "";
            else
                return "NO ES POSIBLE SOLICITAR TURNOS EN LA FECHA ACTUAL. VERIFIQUE LAS FECHAS DE SOLICITUD EN LA PAGINA WEB.";
        }
        return "NO HAY FECHAS DISPONIBLES PARA SOLICITAR TURNOS. VERIFIQUE LAS FECHAS EN LA PAGINA WEB.";

    }

    /**
     * Verifica con los datos del afiliado si ya solicito un turno en este periodo.
     * MJE ERROR: SUS DATOS YA FUERON INGRESADO, NO PUEDE SACAR MÁS DE UN TURNO POR PERÍODO
     * @return boolean devuelve si encontro o no.
     */
    private function tieneTurnoSolicitado($legajo, $nomApe)
    {
        try {
            $fechasTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo (campo nuevo).
            $consulta = "SELECT * FROM solicitudturno AS ST WHERE ((DATE(ST.solicitudTurno_fechaPedido) BETWEEN :inicioSolicitud: AND :finSolicitud:) AND ((ST.solicitudTurno_legajo=:legajo:) OR (ST.solicitudTurno_nomApe LIKE  :nomApe:)))";

            $solicitudTurno = $this->modelsManager->executeQuery($consulta,
                array(
                    'inicioSolicitud' => $fechasTurnos->fechasTurnos_inicioSolicitud,
                    'finSolicitud' => $fechasTurnos->fechasTurnos_finSolicitud,
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

            $this->view->fechaI = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_inicioSolicitud));
            $this->view->fechaF = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_finSolicitud));
            $this->view->diaA = date('d/m/Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
            $this->view->cantA = $ultimoPeriodo->fechasTurnos_cantidadAutorizados;
            $this->view->cantidadDeTurnos = $ultimoPeriodo->fechasTurnos_cantidadDeTurnos;
            $this->view->autorizadosEnviados = $this->cantRtasAutorizadasEnviadas();
        } else {
            $fechaInicio = '-';
            $fechaFin = '-';
            $this->view->fechaI = '-';
            $this->view->fechaF = '-';
            $this->view->diaA = '-';
            $this->view->cantA = '-';
            $this->view->cantidadDeTurnos = '-';
            $this->view->autorizadosEnviados = '-';
            $this->flash->message('problema', 'NO HAY NINGÚN PERIODO HABILITADO PARA SOLICITAR TURNOS.');
        }
        $solicitudes = $this->modelsManager->createBuilder()->from('Solicitudturno');

        $solicitudes->where("solicitudTurno_manual = 0 and (solicitudTurno_fechaPedido between :fI: and :fF:) and solicitudTurno_respuestaEnviada='NO'",
            array('fI' => $fechaInicio, 'fF' => $fechaFin));

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
     * @desc - permitimos editar un
     * @return json
     */
    public function editAction()
    {
        //deshabilitamos la vista para peticiones ajax
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
                        $this->response->setJsonContent(array("res" => "success"));
                        $this->response->setStatusCode(200, "OK");
                    } else {
                        $this->response->setJsonContent(array("res" => "error"));
                        $this->response->setStatusCode(500, "OPS! HAY UN PROBLEMA, POR FAVOR VERIFIQUE QUE TODOS LOS CAMPOS SEAN INGRESADOS.");
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

    /*================================ ADMINISTRADOR =======================================*/
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
     * Envia el correo segun el estado en el que se encuentra serà el mensaje enviado.
     */
    public function enviarRespuestasAction()
    {
        $solicitudesAutorizadas = Solicitudturno::recuperaSolicitudesSegunEstado('AUTORIZADO');
        $solicitudesDenegadas = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO');
        $solicitudesDenegadasFaltaTurnos = Solicitudturno::recuperaSolicitudesSegunEstado('denegado por falta de turnos');

        if (count($solicitudesAutorizadas) == 0 && count($solicitudesDenegadas) == 0 && count($solicitudesDenegadasFaltaTurnos) == 0) {
            $this->flash->message('',"<div><h3>No se pueden enviar respuestas,<br> ya que solo hay solicitudes pendientes o en revisión.</h3></div>");
        } else {
            $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
            $fechaAtencion = TipoFecha::fechaEnLetras($ultimoPeriodo->fechasTurnos_diaAtencion);//date('d-m-Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));

            $textoA = "En respuesta a su solicitud, le informamos que podrá dirigirse al Instituto Municipal de Previsión Social el dia " . $fechaAtencion . " para tramitar un préstamo personal.";
            $textoDxFdT = "En respuesta a su solicitud, le informamos que no es posible otorgarle un turno para tramitar un préstamo personal porque todos los turnos disponibles para este mes ya fueron dados.";
            $textoD = "En respuesta a su solicitud, le informamos que no es posible otorgarle un turno para tramitar un préstamo personal porque ";

            if (count($solicitudesAutorizadas) != 0)
                $this->envioRespuestas($solicitudesAutorizadas, $textoA, 'A');

            if (count($solicitudesDenegadas) != 0)
                $this->envioRespuestas($solicitudesDenegadas, $textoD, 'D');

            if (count($solicitudesDenegadasFaltaTurnos) != 0)
                $this->envioRespuestas($solicitudesDenegadasFaltaTurnos, $textoDxFdT, 'DFT');

            $this->flash->message('','<div><h1>Las respuestas fueron enviadas a los afiliados.</h1></div>');
        }
        $this->view->pick('turnos/vuelta');
    }

    private function envioRespuestas($solicitudes, $texto, $tipoEstado)
    {
        foreach ($solicitudes as $unaSolicitud) {
            $this->enviarEmail($unaSolicitud, $texto, $tipoEstado);
        }
    }


    private function enviarEmail($unaSolicitud, $mensaje, $tipoEstado)
    {
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

        $this->mailDesarrollo->AddBCC($correo, $nomApe);
        $this->mailDesarrollo->From = 'desarrollo@imps.org.ar';
        $this->mailDesarrollo->FromName = 'IMPS - DIVISIÓN AFILIADOS';
        $this->mailDesarrollo->Subject = "Respuesta por solicitud de un turno en IMPS.";

        $idCodif = base64_encode($idSol);

        $texto = "Estimado/a  " . $nomApe . ":<br/> <br/>" . $mensaje;
        $textoFinal = "Para confirmar que recibio este mensaje, por favor"
            . " <a href='http://localhost/impsweb/turnos/confirmaEmail?id=" . $idCodif . "' target='_blank'>haga click aqui.</a>"
            . "<br/><br/> Saluda atte.,<br/> Instituto Municipal de Previsión Social <br/> Fotheringham 277 - Neuquén Capital. <br/> Teléfono:(299)- 4433798";

        if ($tipoEstado == 'A') {
            $cad1 = " El monto máximo que se le puede prestar es $" . $montoM . " y el monto posible que se le puede otorgar es $" . $montoP . ".";
            $cadena = $cad1 . " La cantidad máxima de cuotas es " . $cantCuotas . " y el valor de cada una de ellas es de $" . $valorCuota . '.<br/>';

            if ($obs != '-' && $obs != '')
                $cadena .= "Nota: " . $obs . "<br/>";

            $cadena .= "Recuerde que usted tiene " . $diasConfirmacion . " dias para confirmar el mensaje, de lo contrario el turno sera cancelado.<br/>";

            $this->mailDesarrollo->Body = $texto . '<br/>' . $cadena . $textoFinal;
        } else {   //verificar si es denegado para recuperar el contenido de observaciones.

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
        if (!empty($laSolicitud)){
            $this->view->idSolicitud = $laSolicitud->solicitudTurno_id;//Envio el id de solicitud para generar el pdf.
            $solicitud = new Solicitudturno();
            $resultado = $solicitud->comprobarRespuesta($laSolicitud);
            $this->view->vencido = $resultado['vencido'];
            $this->view->nroTurno = $resultado['nroTurno'];
        }else
            $this->redireccionar('index/index');
    }
    public function comprobanteTurnoAction($idSolicitud)
    {

        $solicitud = Solicitudturno::findFirstBySolicitudTurno_id($idSolicitud);
        $this->tag->setTitle('');//Para que no muestre el titulo en el pdf.
        //GENERAR PDF
        $this->view->disable();
        // Get the view data
        $html = $this->view->getRender('turnos', 'comprobanteTurno', array(
            'solicitud' => $solicitud
        ));
        $pdf = new mPDF();
        $pdf->SetHeader(date('d/m/Y'));
        $pdf->WriteHTML($html, 2);
        $pdf->Output('comprobanteTurno.pdf', "I");



    }

    public function listadoEnPdfAction()
    {
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


    public function editarPeriodoAction($idFechaTurno)
    {
        $unaFechaTurno = Fechasturnos::findFirstByFechasTurnos_id($idFechaTurno);
        $this->view->formulario = new EditarPeriodoForm($unaFechaTurno);
        $this->view->idPeriodo = $idFechaTurno;
    }

    public function guardarDatosEdicionPeriodoAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('idPeriodo');
            $unPeriodo = Fechasturnos::findFirstByFechasTurnos_id($id);
            if ($unPeriodo) {
                $unPeriodo->fechasTurnos_inicioSolicitud = $this->request->getPost('periodoSolicitudDesde');
                $unPeriodo->fechasTurnos_finSolicitud = $this->request->getPost('periodoSolicitudHasta');
                $unPeriodo->fechasTrnos_diaAtencion = $this->request->getPost('periodoAtencionDesde');
                $unPeriodo->fechasTurnos_cantidadDeTurnos = $this->request->getPost('cantidadTurnos');
                $unPeriodo->fechasTurnos_cantidadDiasConfirmacion = $this->request->getPost('cantidadDias');
                $unPeriodo->fechasTurnos_activo = 1;
                if ($unPeriodo->save()) {
                    $this->flash->message('exito', "Los datos se guardaron correctamente!");
                    return $this->dispatcher->forward(array("action" => "verPeriodos"));
                } else {
                    $this->flash->message('problema', "Ocurrio un error, no se pudieron guardar los datos.");
                    return $this->dispatcher->forward(array("action" => "verPeriodos"));
                }
            }
        }
    }


}



