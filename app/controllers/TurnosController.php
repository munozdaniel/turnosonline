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
        $this->assets->collection('headerJs')
            ->addJs('js/jquery.min.js');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
        parent::initialize();
    }

    /**
     * Formulario para solicitar un turno online
     */
    public function indexAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm();
        $this->view->deshabilitar = true;
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('turnos/turnoProcesado');
        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->error("<h1>EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO </h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('turnos/turnoProcesado');
        }
        //verificamos si hay turnos disponibles.
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            $this->flash->error("<h1>LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('turnos/turnoProcesado');
        }
        $this->view->formulario = new TurnosOnlineForm();
        $this->view->deshabilitar = false;
    }

    /**
     * Guarda los datos del afiliados para solicitar el turno.
     * 0. valida si esta dentro del periodo disponible para solicitar turnos.
     * 1. Verifica si hay turnos disponibles.
     * 2. valida sus campos.
     * 3. verifica si los datos ingresados pertenecen a un afiliado de siprea
     * 4. verifica que no haya solicitado otro turno en el periodo actual.
     * 5. verifica que el email no se haya utilizado
     */
    public function guardarTurnoOnlineAction()
    {
        $this->view->setTemplateAfter('admin');
        if (!$this->request->isPost()) {
            return $this->response->redirect('index/index');
        }
        $this->view->formulario = new TurnosOnlineForm(null, array('disabled' => 'true'));

        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        // 0. valida si esta dentro del periodo disponible para solicitar turnos.
        if (!$ultimoPeriodo || !$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            return $this->redireccionar('turnos/index');
        }
        //1. Verifica si hay turnos disponibles
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            return $this->redireccionar('turnos/index');
        }
        //2. valida los campos del formulario.
        $data = $this->request->getPost();
        $turnosOnlineForm = new TurnosOnlineForm();
        $this->view->formulario = $turnosOnlineForm;

        if ($turnosOnlineForm->isValid($data) == false) {
            foreach ($turnosOnlineForm->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            return $this->redireccionar('turnos/index');
        }
        //Filtramos los campos
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

        //3. verifica si los datos ingresados pertenecen a un afiliado de siprea
        $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);
        if (!$nombreCompleto) {
            $this->flash->error('<h1>USTED NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA OBTENER MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.</h1>');
            return $this->redireccionar('turnos/index');
        }
        // 4. verifica que no haya solicitado otro turno en el periodo actual.
        if ($this->tieneTurnoSolicitado($legajo, $nombreCompleto)) {
            $this->flash->error('<h1>SUS DATOS YA FUERON INGRESADOS, NO PUEDE OBTENER MÁS DE UN TURNO POR PERÍODO</h1>');
            return $this->redireccionar('turnos/index');
        }
        //5. verifica que el email no se haya utilizado
        if ($this->existeEmailEnElPeriodo($ultimoPeriodo, $email)) {
            $this->flash->error('<h1>EL EMAIL INGRESADO YA HA SIDO UTILIZADO PARA SOLICITAR UN TURNO</h1>');
            return $this->redireccionar('turnos/index');
        }
        //6. Guardar los datos.
        $turno = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email,
            $numTelefono, $ultimoPeriodo->getFechasturnosId());

        if (!$turno)//la solicitud se ingreso con exito.
        {
            $this->flash->error('<h1>OCURRIO UN PROBLEMA, POR FAVOR VUELVA A INTENTARLO EN UNOS MINUTOS</h1>');
            return $this->redireccionar('turnos/index');
        }
        $this->flash->notice('<h1><i class="fa fa-info-circle fa-3x pull-left" style="display: inline-block;"></i>LA SOLICITUD FUE INGRESADA CORRECTAMENTE</h1>
                                <h3>Cuando nuestros empleados finalicen con el análisis de su estado
                                de deuda se le enviará un correo electrónico con el resumen del análisis.
                                </h3>');
        $turnosOnlineForm->clear();
        return $this->redireccionar('turnos/turnoProcesado');
    }

    /**
     * Verifica si el correo ya fue utilizado para solicitar un turno en el periodo activo
     * @param $email
     * @return bool
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
     */
    public function solicitudManualAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm(null, array('manual' => true));
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h3>NO HAY NINGÚN PERIODO DISPONIBLE</h3>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h3><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h3>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('administrar/index');

        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->error("<h3>EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO </h3>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h3><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h3>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('administrar/index');

        }

        $info = array();
        $info['cantidadAutorizados'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
        $info['cantidadTurnos'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
        $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosIniciosolicitud()));
        $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosFinsolicitud()));
        $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencion()));
        $info['diaAtencionFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencionfinal()));
        $this->view->informacion = $info;
        if ($ultimoPeriodo->getFechasturnosCantidadautorizados() == $ultimoPeriodo->getFechasturnosCantidaddeturnos()) {
            $this->view->rojo = true;
        } else {
            $this->view->rojo = false;
        }

    }

    /**
     * Guarda la solicitud manual.
     */
    public function guardarSolicitudManualAction()
    {
        if (!$this->request->isPost()) {
            $this->redireccionar('index/index');
        }

        $turnoManualForm = new TurnosOnlineForm(null, array('manual' => true));
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        if ($turnoManualForm->isValid($this->request->getPost()) != false) {
            //Filtrando
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
            $email = $this->request->getPost('solicitudTurno_email');
            //Volvemos a comprobar en caso que haya tardado mucho en llenar el formulario.
            //Verificamos si existe un periodo disponible.
            if (!$ultimoPeriodo) {
                $this->flash->error("<h3>NO HAY NINGÚN PERIODO DISPONIBLE</h3>");
                $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h3><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h3>", 'class' => 'text-decoration-none ')));
                return $this->redireccionar('administrar/index');

            }
            //Verifificamos si el plazo para solicitar turnos venció.
            if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
                $this->flash->error("<h3>EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO </h3>");
                $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h3><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h3>", 'class' => 'text-decoration-none ')));
                return $this->redireccionar('administrar/index');

            }
            //verificamos si hay turnos disponibles.
            if (!$ultimoPeriodo->hayTurnosDisponibles()) {
                $this->flash->error("<h3>LAMENTABLEMENTE NO HAY TURNOS DISPONIBLES</h3>");
                $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h3><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h3>", 'class' => 'text-decoration-none ')));
                return $this->redireccionar('administrar/index');
            }

            $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);
            if ($nombreCompleto == "") {
                $this->flash->error('<h3>EL AFILIADO NO ESTA REGISTRADO EN EL SISTEMA O ALGUNO DE LOS DATOS INGRESADOS SON INCORRECTOS.</h3>');
                return $this->redireccionar('turnos/solicitudManual');
            }
            if ($this->tieneTurnoSolicitado($legajo, $nombreCompleto, null)) {
                $this->flash->error('<h3>EL AFILIADO YA SOLICITO UN TURNO, POR LO CUAL NO SE PUEDE INGRESAR ESTA SOLICITUD.</h3>');
                return $this->redireccionar('turnos/solicitudManual');
            }
            $codigo = null;
            if ($estado == "AUTORIZADO") {
                $codigo = $this->getRandomCode($ultimoPeriodo->getFechasturnosId());
            }
            $solicitud = Solicitudturno::accionAgregarUnaSolicitudManual($legajo, $nombreCompleto,
                $documento, $numTelefono, $estado, $nickActual, $ultimoPeriodo->getFechasturnosId(), $email, $codigo);
            if (empty($solicitud)) {
                $this->flash->error("<h3>OCURRIÓ UN PROBLEMA AL GUARDAR LOS DATOS, POR FAVOR INTENTELO NUEVAMENTE.
                        EN CASO QUE EL PROBLEMA PERSISTA COMUNICARSE CON EL SOPORTE TÉCNICO.</h3>");
                return $this->redireccionar('turnos/solicitudManual');
            }
            Fechasturnos::incrementarCantAutorizados();
            $turnoManualForm->clear();
            $boton = $this->tag->form(array('turnos/comprobanteTurnoPost', 'method' => 'POST'));
            $encode = base64_encode($solicitud->getSolicitudturnoId());
            $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $encode));
            $boton .= "<button type='submit' class='btn btn-info btn-lg' formtarget='_blank'><i class='fa fa-print'></i> IMPRIMIR COMPROBANTE DE TURNO</button>";
            $boton .= "</form>";
            $this->flash->notice($boton);


            $this->view->formulario = $turnoManualForm;
            return $this->redireccionar('turnos/solicitudManual');

        } else {
            foreach ($turnoManualForm->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            return $this->redireccionar('turnos/solicitudManual');

        }


    }

    /**
     * Verifica que los datos ingresados por parametros se encuentren en la bd de siprea.
     * @param $legajo int corresponde al legajo del afiliado.
     * @param $nombreCompleto String corresponde a los apellidos concatenados con los nombres, separados por espacio.
     * No es necesario que este completo.
     * @return bool|string
     */
    private function comprobarDatosEnSiprea($legajo, $nombreCompleto)
    {
        try {
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom
                      FROM siprea2.afiliados AS AF
                       WHERE (AF.afiliado_apenom LIKE '%" . $nombreCompleto . "%')
                       AND (AF.afiliado_legajo LIKE '%" . $legajo . "%')
                        AND (AF.afiliado_activo = 1);";
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
        return false;
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

    /**
     * Muestra los mensajes correspondientes cuando el usuario solicita un turno online.
     */
    public function turnoProcesadoAction()
    {
        //este action solo se utiliza para poder redireccionarse a la vista correspondiente.
    }

    /*================================ SUPERVISOR =======================================*/
    /**
     * Formulario para guardar un nuevo periodo
     */
    public function periodoSolicitudAction()
    {
        $this->view->formulario = new PeriodoSolicitudForm();
    }

    /**
     * Guarda un nuevo periodo. Deshabilita el periodo anterior.
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
                $this->db->begin();
                //Comprobamos que: fechasTurnos_finSolicitud + cantidadDiasConfirmacion < fechasTurnos_diaAtencion
                $cantidadDiasConfirmacion = $this->request->getPost('fechasTurnos_cantidadDiasConfirmacion', 'int');
                $fechasTurnos_inicioSolicitud = $this->request->getPost('fechasTurnos_inicioSolicitud');
                $periodoSolicitudHasta = $this->request->getPost('fechasTurnos_finSolicitud');
                $periodoDiaAtencion = $this->request->getPost('fechasTurnos_diaAtencion');
                $periodoDiaAtencionFinal = $this->request->getPost('fechasTurnos_diaAtencionFinal');

                $fechaVencimiento = TipoFecha::sumarDiasAlDate($cantidadDiasConfirmacion, $periodoSolicitudHasta);

                if ($fechaVencimiento < $periodoDiaAtencion) {
                    $fechasTurnos = new Fechasturnos();
                    $fechasTurnos->assign(array(
                        'fechasTurnos_inicioSolicitud' => $fechasTurnos_inicioSolicitud,
                        'fechasTurnos_finSolicitud' => $periodoSolicitudHasta,
                        'fechasTurnos_diaAtencion' => $periodoDiaAtencion,
                        'fechasTurnos_diaAtencionFinal' => $periodoDiaAtencionFinal,
                        'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('fechasTurnos_cantidadDeTurnos', 'int'),
                        'fechasTurnos_cantidadAutorizados' => 0,
                        'fechasTurnos_cantidadDiasConfirmacion' => $cantidadDiasConfirmacion,
                        'fechasTurnos_activo' => 1,
                        'fechasTurnos_sinTurnos' => 1,
                    ));
                    if (!$fechasTurnos->save()) {
                        foreach ($fechasTurnos->getMessages() as $mensaje) {
                            $this->flash->error($mensaje);
                        }
                        $this->db->rollback();
                        return $this->redireccionar('turnos/periodoSolicitud');
                    }

                    //Si ya habia un periodo, lo desactivamos.
                    if ($fechasTurnos->getFechasturnosId() > 1) {
                        $id = $fechasTurnos->getFechasturnosId() - 1;
                        $phql = "UPDATE Fechasturnos SET fechasTurnos_activo=0 WHERE fechasTurnos_id = :id:";
                        $this->modelsManager->executeQuery($phql, array('id' => $id));
                    }

                    //-----------------------------------------------------
                    //Creo un nuevo schedule
                    $puntoProgramado = \Modules\Models\Schedule::crearSchedule('plazo', 'Vencimiento de Periodo', $fechasTurnos_inicioSolicitud, $periodoSolicitudHasta);
                    if (!$puntoProgramado) {
                        $this->flash->message('problema', 'Surgió un problema al insertar un nuevo punto programado.');
                        $this->db->rollback();
                        return $this->redireccionar('turnos/periodoSolicitud');
                    }
                    //-----------------------------------------------------
                    $this->db->commit();
                    $this->flash->message('exito', 'La configuración de las fechas se ha realizado satisfactoriamente.');
                    $periodoSolicitudForm->clear();
                    return $this->redireccionar('administrar/index');
                } else {
                    $this->flash->message('problema', "Deberá modificar el <ins>periodo de atención de turnos</ins> para que el afiliado tenga tiempo de <strong>confirmar el mensaje</strong>.");
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
            $this->flash->error("NO SE HA PODIDO DESHABILITAR EL PERIODO, INFORMAR AL SOPORTE TÉCNICO.");
        $this->redireccionar('turnos/verPeriodos');
    }

    /**
     * Muestra una grilla paginada con los datos de los afiliados que solicitaron turnos.
     *
     *
     */
    public function turnosSolicitadosAction()
    {
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm(null, array('manual' => true));
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE</h1>");
            return $this->redireccionar('administrar/index');

        }

        $info = array();
        $info['cantidadAutorizados'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
        $info['cantidadTurnos'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
        $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosIniciosolicitud()));
        $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosFinsolicitud()));
        $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencion()));
        $info['diaAtencionFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencionfinal()));
        $info['autorizadosEnviados'] = $this->cantRtasAutorizadasEnviadas();

        $this->view->informacion = $info;
        if ($ultimoPeriodo->getFechasturnosCantidadautorizados() == $ultimoPeriodo->getFechasturnosCantidaddeturnos()) {
            $this->view->rojo = true;
        } else {
            $this->view->rojo = false;
        }
        //Buscamos turnos online y terminal que tengan respuestaEnviada=NO.
        $solicitudes = $this->modelsManager->createBuilder()
            ->addFrom('Solicitudturno', 'S')
            ->join('Fechasturnos', 'S.solicitudTurnos_fechasTurnos = F.fechasTurnos_id ', 'F')
            ->where(" F.fechasTurnos_activo=1 AND S.solicitudTurno_tipoTurnoId != 3  AND
             (S.solicitudTurno_fechaPedido between :fI: and :fF:) and S.solicitudTurno_respuestaEnviada='NO'",
                array('fI' => $ultimoPeriodo->getFechasturnosIniciosolicitud(),
                    'fF' => $ultimoPeriodo->getFechasturnosFinsolicitud()))
            ->orderBy('S.solicitudTurno_id ASC');

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
                $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id:',
                    'bind' => array('solicitudTurno_id' => $this->request->getPost('solicitudTurno_id', 'int'))));
                if (!$solicitudTurno) {
                    $this->response->setJsonContent(array("res" => "warning"));
                    $this->response->setStatusCode(500, "Ocurrió un error, no se pudieron guardar los datos. Comunicarse con Soporte Técnico." . $this->request->getPost('solicitudTurno_id'));
                    $this->response->send();
                    return;
                }
                $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));

                $estadoAntiguo = $solicitudTurno->getSolicitudturnoEstado();
                $estadoNuevo = $this->request->getPost('solicitudTurno_estado');

                //Actualizando la instancia de solicitudTurno
                $solicitudTurno->setSolicitudTurnoEstado($estadoNuevo);

                if ($estadoAntiguo == 'DENEGADO POR FALTA DE TURNOS' && $estadoNuevo == 'AUTORIZADO') //modif(nov/2015)
                {
                    if ($ultimoPeriodo->getFechasturnosCantidaddeturnos() == $ultimoPeriodo->getFechasturnosCantidadautorizados()) {
                        $data['CANTIDAD'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
                        $data['AUTORIZADO'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
                        $solicitudTurno->setSolicitudturnoEstado('DENEGADO POR FALTA DE TURNOS');
                        $solicitudTurno->setSolicitudturnoMontomax(0);
                        $solicitudTurno->setSolicitudturnoMontoposible(0);
                        $solicitudTurno->setSolicitudturnoCantcuotas(0);
                        $solicitudTurno->setSolicitudturnoValorcuota(0);
                        $solicitudTurno->setSolicitudturnoObservaciones('-');
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('y-m-d'));
                    } else {
                        Fechasturnos::incrementarCantAutorizados();
                        $solicitudTurno->setSolicitudturnoMontomax($this->request->getPost('solicitudTurno_montoMax', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoMontoposible($this->request->getPost('solicitudTurno_montoPosible', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoCantcuotas($this->request->getPost('solicitudTurno_cantCuotas', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoValorcuota($this->request->getPost('solicitudTurno_valorCuota', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('solicitudTurno_observaciones', array('string')));
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('y-m-d'));
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
                        $solicitudTurno->setSolicitudturnoMontomax($this->request->getPost('solicitudTurno_montoMax', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoMontoposible($this->request->getPost('solicitudTurno_montoPosible', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoCantcuotas($this->request->getPost('solicitudTurno_cantCuotas', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoValorcuota($this->request->getPost('solicitudTurno_valorCuota', array('int', 'trim')));
                        $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('solicitudTurno_observaciones', array('string')));
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('y-m-d'));
                    } else {
                        $solicitudTurno->setSolicitudturnoMontomax(0);
                        $solicitudTurno->setSolicitudturnoMontoposible(0);
                        $solicitudTurno->setSolicitudturnoCantcuotas(0);
                        $solicitudTurno->setSolicitudturnoValorcuota(0);

                        if ($estadoNuevo == "DENEGADO")
                            $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('causa'));
                        else
                            $solicitudTurno->setSolicitudturnoObservaciones("-");

                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('y-m-d'));
                    }
                }

                if ($solicitudTurno->update()) {
                    $this->response->setJsonContent(array("res" => "success", "datos" => $data));
                    $this->response->setStatusCode(200, "OK");
                } else {
                }

                $this->response->send();
                return;
            }
        }
    }


    /**
     * Muestra la tabla donde van a ir todos los turnos que fueron respondidos, y muestra los estados individuales de cada uno.
     * @param null $tipoTurno
     * @return null
     */
    public function turnosRespondidosAction($tipoTurno = null)
    {
        $this->importarDataTables();
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm(null, array('manual' => true));
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('administrar/index');

        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO</h3>');
        }
        //verificamos si hay turnos disponibles.
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> NO HAY TURNOS DISPONIBLES</h3>');
        }
        $info = array();
        $info['cantidadAutorizados'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
        $info['cantidadTurnos'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
        $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosIniciosolicitud()));
        $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosFinsolicitud()));
        $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencion()));
        $info['diaAtencionFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencionfinal()));
        $this->view->informacion = $info;


        if ($ultimoPeriodo->getFechasturnosCantidadautorizados() == $ultimoPeriodo->getFechasturnosCantidaddeturnos()) {
            $this->view->rojo = true;
        } else {
            $this->view->rojo = false;
        }
        /* $paginator = new PaginatorArray
         (
             array(
                 "data" => Solicitudturno::accionVerSolicitudesConRespuestaEnviada($tipoTurno),
                 "limit" => 10,
                 "page" => $this->request->getQuery('page', 'int')
             )
         );
         $this->view->page = $paginator->getPaginate();*/


    }

    /**
     * Metodo ajax para completar la tabla de turnos respondidos, filtra y devuelve un arreglo de arreglos.
     * @return array
     */
    public function turnosRespondidosAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $datos = array();

        $fechaTurnos = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));//Obtengo el periodo activo.
        $solicitudesOnline = array();

        if ($fechaTurnos) {
            $fechaSolicitudInicial = $fechaTurnos->getFechasturnosIniciosolicitud();
            $fechaSolicitudFinal = $fechaTurnos->getFechasturnosFinsolicitud();
            $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id: AND solicitudTurno_cancelado=0',
                'bind' => array('fechasTurnos_id' => $fechaTurnos->getFechasturnosId()),
                'order' => 'solicitudTurno_fechaProcesamiento ASC'));

            foreach ($solicitudes as $unaSolicitud) {
                if ($unaSolicitud->getSolicitudturnoRespuestaenviada() == 'SI') {
                    $item = array();
                    $item[] = $unaSolicitud->getSolicitudturnoCodigo();
                    $item[] = $unaSolicitud->getSolicitudturnoLegajo();
                    $item[] = $unaSolicitud->getSolicitudturnoNomape();
                    //Email
                    if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                        $item[] = '';
                    else
                        $item[] = "<i class='fa fa-envelope-o'></i> " . $unaSolicitud->getSolicitudturnoEmail();
                    //Telefono
                    $item[] = $unaSolicitud->getSolicitudturnoNumtelefono();
                    $item[] = $unaSolicitud->getSolicitudturnoFecharespuestaenviada();
                    $item[] = $unaSolicitud->getSolicitudturnoNickusuario();
                    //Respuesta chequeda
                    $respondio = "";
                    $comprobante = "";
                    $idCodificado = base64_encode($unaSolicitud->getSolicitudturnoId());
                    //Controlo si las respuesta se vencio
                    if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 0) {
                        //NO
                        $respondio = '<a class="parpadea btn btn-white" style="display:inline-block;"><i class="fa fa-spinner fa-spin  fa-fw margin-bottom"></i>
                                        <span class="sr-only">Loading...</span>EN ESPERA</a>' .
                            '<a onclick="confirmarAsistencia('.$unaSolicitud->getSolicitudturnoId().',' . $unaSolicitud->getSolicitudturnoLegajo() . ',\''.$unaSolicitud->getSolicitudturnoCodigo().'\')" class=" btn btn-danger" style="display:inline-block;"><em>CONFIRMAR</em></i>';
                    } else {
                        if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 1) {
                            //SI
                            $respondio = '<a class="btn btn-block btn-white"><i class="fa fa-check-square" style="color:#0ec705"></i> ' . "INFORMACIÓN CONFIRMADA</a>";
                            if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 1) {
                                $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado
                                , '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ', 'class' => 'btn btn-info btn-block', 'target' => '_blank'));;
                            } else {
                                if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 2) {
                                    $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado
                                    , '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ', 'class' => 'btn btn-success btn-block', 'target' => '_blank'));;
                                } else {
                                    if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 3) {
                                        $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado
                                        , '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ', 'class' => 'btn btn-warning btn-block', 'target' => '_blank'));;
                                    }
                                }
                            }
                        } else {
                            if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 2) {
                                //CANCELADO, VENCIÓ
                                $respondio = '<a class="btn btn-block btn-white">
                                                <i class="fa fa-ban text-danger"></i>
                                                ' . "PLAZO VENCIDO</a>";
                            }
                        }
                    }
                    if ($comprobante == "") {
                        if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 1) {
                            $comprobante = '<a class="btn btn-block btn-info" > <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong></a>';
                        } else {
                            if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 2) {
                                $comprobante = '<a class="btn btn-block btn-success" > <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong></a>';
                            } else {
                                if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 3) {
                                    $comprobante = '<a class="btn btn-block btn-warning" > <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong></a>';
                                }
                            }
                        }
                    }
                    $item[] = $unaSolicitud->getSolicitudturnoEstado();
                    $item[] = $respondio;
                    $item[] = $comprobante;
                    $item[] = $unaSolicitud->getSolicitudturnoTipoturnoid();//Para comprobar el tipo y cambiar el background-color
                    $datos[] = $item;
                    //Tipo de Turno
                    /* $tipoTurno = "";
                     if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 1) {
                         //Online
                         $tipoTurno = $this->tag->linkTo(array('turnos/comprobanteTurno/?id='.$idCodificado
                         ,'<i class="'.$icono.'"></i> <strong>ONLINE</strong> ','class'=>'btn btn-info btn-block','target'=>'_blank')) ;

                     } else {
                         if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 2) {
                             //Terminal
                             $tipoTurno = $this->tag->linkTo(array('turnos/comprobanteTurno/?id='.$idCodificado
                             ,'<i class="'.$icono.'"></i> <strong>TERMINAL</strong> ','class'=>'btn btn-warning btn-block','target'=>'_blank')) ;

                         } else {
                             if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 3) {
                                 //Manual
                                 $tipoTurno = $this->tag->linkTo(array('turnos/comprobanteTurno/?id='.$idCodificado
                                     ,'<i class="'.$icono.'"></i> <strong>MANUAL</strong> ','class'=>'btn btn-success btn-block','target'=>'_blank')) ;
                             }
                         }
                     }*/

                }
            }
        }


        $retorno['data'] = $datos;
        echo json_encode($retorno);
        return;

    }

    /**
     * Muestra la tabla donde van a ir todos los turnos que fueron cancelados, ya sea por vencimiento
     * o por que el afiliado lo cancelo. Siempre serán del ultimo periodo.
     * @param null $tipoTurno
     * @return null
     */
    public function turnosCanceladosAction($tipoTurno = null)
    {
        $this->importarDataTables();
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        $this->view->formulario = new TurnosOnlineForm(null, array('manual' => true));
        //Verificamos si existe un periodo disponible.
        if (!$ultimoPeriodo) {
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('administrar/index');

        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> EL PLAZO PARA SOLICITAR TURNO NO ESTÁ HABILITADO</h3>');
        }
        //verificamos si hay turnos disponibles.
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> NO HAY TURNOS DISPONIBLES</h3>');
        }
        $info = array();
        $info['cantidadAutorizados'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
        $info['cantidadTurnos'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
        $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosIniciosolicitud()));
        $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosFinsolicitud()));
        $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencion()));
        $info['diaAtencionFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencionfinal()));
        $this->view->informacion = $info;


        if ($ultimoPeriodo->getFechasturnosCantidadautorizados() == $ultimoPeriodo->getFechasturnosCantidaddeturnos()) {
            $this->view->rojo = true;
        } else {
            $this->view->rojo = false;
        }
    }

    /**
     * Metodo ajax para completar la tabla de turnos respondidos, filtra y devuelve un arreglo de arreglos.
     * @return array
     */
    public function turnosCanceladosAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $datos = array();

        $phql = "SELECT MAX(fechasTurnos_id) AS ultimoPeriodo FROM Fechasturnos";
        $rows = $this->modelsManager->executeQuery($phql);
        foreach ($rows as $row) {
            $fechaTurnos_id = $row["ultimoPeriodo"];
        }
        $fechaTurnos = Fechasturnos::findFirst(array('fechasTurnos_id=' . $fechaTurnos_id));//Obtengo el periodo activo.
        $solicitudesOnline = array();

        if ($fechaTurnos) {
            $fechaSolicitudInicial = $fechaTurnos->getFechasturnosIniciosolicitud();
            $fechaSolicitudFinal = $fechaTurnos->getFechasturnosFinsolicitud();
            $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id: AND solicitudTurno_cancelado=1',
                'bind' => array('fechasTurnos_id' => $fechaTurnos->getFechasturnosId()),
                'order' => 'solicitudTurno_fechaProcesamiento DESC'));

            foreach ($solicitudes as $unaSolicitud) {
                if ($unaSolicitud->getSolicitudturnoRespuestaenviada() == 'SI') {
                    $item = array();
                    $item[] = $unaSolicitud->getSolicitudturnoCodigo();
                    $item[] = $unaSolicitud->getSolicitudturnoLegajo();
                    $item[] = $unaSolicitud->getSolicitudturnoNomape();
                    //Email
                    if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                        $item[] = '';
                    else
                        $item[] = "<i class='fa fa-envelope-o'></i> " . $unaSolicitud->getSolicitudturnoEmail();
                    //Telefono
                    $item[] = $unaSolicitud->getSolicitudturnoNumtelefono();
                    $item[] = $unaSolicitud->getSolicitudturnoEstado();
                    $item[] = $unaSolicitud->getSolicitudturnoFecharespuestaenviada();
                    $item[] = $unaSolicitud->getSolicitudturnoNickusuario();
                    //Respuesta chequeda
                    $respondio = "";
                    $comprobante = '<a class="btn btn-block btn-gris"> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> </a>';
                    $idCodificado = base64_encode($unaSolicitud->getSolicitudturnoId());
                    if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 0) {
                        //NO
                        $respondio = '<i class="fa fa-spinner fa-spin  fa-fw margin-bottom"></i>
                                        <span class="sr-only">Loading...</span>
                                        ' . " EN ESPERA";

                    } else {
                        if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 1) {
                            //SI
                            $respondio = '<i class="fa fa-check-square" style="color:#0ec705"></i> ' . "ASISTENCIA CONFIRMADA";
                            $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado
                            , '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ', 'class' => 'btn btn-info btn-block', 'target' => '_blank'));;
                        } else {
                            if ($unaSolicitud->getSolicitudturnoRespuestachequeada() == 2) {
                                //CANCELADO, VENCIÓ
                                $respondio = '
                                                <i class="fa fa-ban text-danger"></i>
                                                ' . "PLAZO VENCIDO";
                            }
                        }
                    }
                    $item[] = $respondio;
                    $item[] = $comprobante;
                    $item[] = $unaSolicitud->getSolicitudturnoTipoturnoid();//Para comprobar el tipo y cambiar el background-color
                    $item[] = $unaSolicitud->getSolicitudturnoSanciones();
                    $datos[] = $item;


                }
            }
        }


        $retorno['data'] = $datos;
        echo json_encode($retorno);
        return;

    }

    /**
     * @return int
     */
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


    /**
     * Envia el correo segun el estado en el que se encuentra sera el mensaje enviado.
     * Si es una solicitud Personal/Terminal también se generará un numero de comprobante pero no se enviará ningún correo.
     */
    public function enviarRespuestasAction()
    {
        $usuarioActual = $this->session->get('auth')['usuario_nick'];
        $ultimoPeriodo = Fechasturnos::findFirst("fechasTurnos_activo=1");

        $solicitudesAutorizadas = Solicitudturno::recuperaSolicitudesSegunEstado('AUTORIZADO', $usuarioActual, $ultimoPeriodo);
        $solicitudesDenegadas = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO', $usuarioActual, $ultimoPeriodo);
        $solicitudesDenegadasFaltaTurnos = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO POR FALTA DE TURNOS', $usuarioActual, $ultimoPeriodo);

        if (count($solicitudesAutorizadas) == 0 && count($solicitudesDenegadas) == 0 && count($solicitudesDenegadasFaltaTurnos) == 0) {
            $this->flashSession->error('<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> NO SE ENVIARON LAS RESPUESTAS, YA QUE SOLO HAY SOLICITUDES PENDIENTES O EN REVISIÓN.</h3>');
            return $this->response->redirect('turnos/turnosSolicitados');
        }
        $fechaAtencion = TipoFecha::fechaEnLetras($ultimoPeriodo->getFechasturnosDiaatencion());//date('d-m-Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));
        //FIXME: Preguntar como serán los mensajes que se van a enviar a los afiliados.
        $textoA = "En respuesta a su solicitud, le comunicamos que podrá dirigirse a nuestra institución el día " . $fechaAtencion . " para <b>trámitar</b> un préstamo personal.";
        $textoDxFdT = "En respuesta a su solicitud, le comunicamos que no es posible otorgarle un turno para trámitar un préstamo personal porque todos los turnos disponibles para este mes ya fueron dados.";
        $textoD = "En respuesta a su solicitud, le comunicamos que no es posible otorgarle un turno para trámitar un préstamo personal porque ";

        if (count($solicitudesAutorizadas) != 0)
            $this->envioRespuestas($solicitudesAutorizadas, $textoA, 'A', $ultimoPeriodo);

        if (count($solicitudesDenegadas) != 0)
            $this->envioRespuestas($solicitudesDenegadas, $textoD, 'D');

        if (count($solicitudesDenegadasFaltaTurnos) != 0)
            $this->envioRespuestas($solicitudesDenegadasFaltaTurnos, $textoDxFdT, 'DFT');
        $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> LAS RESPUESTAS FUERON ENVIADAS A LOS AFILIADOS</h3>');
    }

    /**
     * Verifica si la solicitud es Terminal para generar el codigo de turno. Si la solicitud es online, envia
     * un correo al afiliado.
     * @param $solicitudes
     * @param $texto
     * @param $tipoEstado
     * @param null $ultimoPeriodo
     */
    private function envioRespuestas($solicitudes, $texto, $tipoEstado, $ultimoPeriodo = null)
    {
        foreach ($solicitudes as $solicitud) {

            if ($solicitud->getSolicitudturnoTipoturnoid() == 2) {
                //Es un turno solicitado por la terminal.
                if ($tipoEstado == 'A') {
                    //Está Autorizado, generar codigo
                    $codigo = $this->getRandomCode($ultimoPeriodo->getFechasTurnosId());
                    $solicitud->setSolicitudturnoCodigo($codigo);
                    if ($solicitud->getSolicitudturnosOrden() == NULL || $solicitud->getSolicitudturnosOrden() == 0)
                        $solicitud->getSolicitudturnosOrden(1);
                    else
                        $solicitud->getSolicitudturnosOrden($solicitud->getSolicitudturnosOrden() + 1);
                    if (!$solicitud->update()) {
                        $this->flash->error("Ocurrió un error al generar el codigo de turno para el afiliado con legajo: " . $solicitud->getSolicitudTurnoLegajo());
                    }
                    $ultimoPeriodo->setFechasturnosCantidadautorizados($ultimoPeriodo->getFechasturnosCantidadautorizados() + 1);
                    if (!$ultimoPeriodo->update()) {
                        $this->flash->error("Ocurrió un problema, no se pudo incrementar la cantidad de autorizados. Informar al Soporte Técnico.");
                    }
                }
            } else {
                $this->enviarEmail($solicitud, $texto, $tipoEstado, $ultimoPeriodo);
            }
        }
    }

    /**
     * Envia el correo al afiliado.
     * @param $unaSolicitud
     * @param $mensaje
     * @param $tipoEstado
     */
    private function enviarEmail($unaSolicitud, $mensaje, $tipoEstado, $unPeriodo)
    {
        if ($unaSolicitud->getSolicitudturnoEmail() != "" || $unaSolicitud->getSolicitudturnoEmail() != null) {
            $diasConfirmacion = $unPeriodo->fechasTurnos_cantidadDiasConfirmacion;

            $idSol = $unaSolicitud->getSolicitudturnoId();
            $correo = $unaSolicitud->getSolicitudturnoEmail();
            $nomApe = $unaSolicitud->getSolicitudturnoNomape();
            $montoM = $unaSolicitud->getSolicitudturnoMontomax();
            $montoP = $unaSolicitud->getSolicitudturnoMontoposible();
            $cantCuotas = $unaSolicitud->getSolicitudturnoCantcuotas();
            $valorCuota = $unaSolicitud->getSolicitudturnoValorcuota();
            $obs = $unaSolicitud->getSolicitudturnoObservaciones();

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
        $idSolicitud = $this->request->get('id', 'trim');//Se obtiene por url.
        $id = base64_decode($idSolicitud);
        //$laSolicitud = Solicitudturno::findFirst(array('solicitudTurno_id=:id: AND solicitudTurno_habilitado=1','bind'=>array('id'=>$id)));
        $solicitud = Solicitudturno::findFirst(array('solicitudTurno_id=:id: AND solicitudTurno_cancelado=0', 'bind' => array('id' => $id)));
        if (!$solicitud) {
            $this->flash->error("NO SE HA ENCONTRADO LA PETICIÓN SOLICITADA");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        if (!$ultimoPeriodo) {
            $this->flash->error("EL PERIODO PARA LOS TURNOS ONLINE HA FINALIZADO. ");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        $estado = $solicitud->getSolicitudturnoEstado();
        if ($estado == 'AUTORIZADO') {

            if ($solicitud->getSolicitudturnoRespuestachequeada() == 1) {


                $this->flash->notice('<h1 align="left"><i class="fa fa-info-circle fa-3x pull-left" style="display: inline-block;"></i>
                                    EL CORREO YA FUE CONFIRMADO ANTERIORMENTE</h1>
                                <h3>
                                    <ins>CODIGO DE OPERACIÓN</ins>: <strong>' .
                    $solicitud->getSolicitudturnoCodigo() . '</strong> </h3>  <br>');

                $idCodificado = base64_encode($solicitud->getSolicitudturnoId());
                $boton = $this->tag->form(array('turnos/comprobanteTurnoPost', 'method' => 'POST'));
                $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $idCodificado));
                $boton .= "<button type='submit' class='btn btn-info btn-lg' formtarget='_blank'><i class='fa fa-print'></i> IMPRIMIR COMPROBANTE DE TURNO</button>";
                $boton .= "</form>";
                $this->flash->notice($boton);

            } else {
                if (!Fechasturnos::verificaSiHayTurnosEnPeriodo()) {
                    $this->flash->error("LAMENTABLEMENTE LA CONFIRMACIÓN NO SE HIZO A TIEMPO, SE HAN AGOTADO LOS TURNOS DISPONIBLES.");
                    return $this->redireccionar('turnos/resultadoConfirmacion');
                }

                //Primera vez que acciona el vinculo: verificamos si el plazo para confirmar vencio, sino generamos el codigo.
                $vencido = Fechasturnos::vencePlazoConfirmacion($ultimoPeriodo->getFechasturnosCantidaddiasconfirmacion(), $ultimoPeriodo->getFechasturnosFinsolicitud());
                if ($vencido) {
                    $this->flash->error("EL PERIODO PARA CONFIRMAR EL TURNO HA FINALIZADO");
                    return $this->redireccionar('turnos/resultadoConfirmacion');
                }
                $this->db->begin();
                $solicitud->setSolicitudturnoRespuestachequeada(1);
                $solicitud->setSolicitudturnoFechaconfirmacion(Date('Y-m-d'));
                $codigo = $this->getRandomCode($ultimoPeriodo->getFechasturnosId());
                $solicitud->setSolicitudturnoCodigo($codigo);
                if (!$solicitud->update()) {
                    $this->flash->error("OCURRIO UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.");
                    $this->db->rollback();
                } else {
                    $ultimoPeriodo->setFechasturnosCantidadautorizados($ultimoPeriodo->getFechasturnosCantidadautorizados() + 1);
                    if (!$ultimoPeriodo->update()) {
                        $this->flash->error("OCURRIO UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.");
                        $this->db->rollback();
                    } else {
                        $idCodificado = base64_encode($solicitud->getSolicitudturnoId());
                        $boton = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado, 'GENERAR COMPROBANTE', 'class' => 'btn btn-info btn-lg', 'target' => '_blank'));
                        $this->flash->notice('<h1 align="center"><i class="fa fa-info-circle fa-3x pull-left" style="display: inline-block;"></i>
                                    GRACIAS POR SU CONFIRMACIÓN</h1>
                                <h3>
                                    <ins>CODIGO DE OPERACIÓN</ins>: <strong>' .
                            $solicitud->getSolicitudturnoCodigo() . '</strong> </h3>  <br>' . $boton);
                        $this->db->commit();
                    }
                }
            }
            $this->view->solicitud_id = $solicitud->getSolicitudturnoId();
            $this->view->codigo = $solicitud->getSolicitudturnoCodigo();
        }
        if ($estado == 'DENEGADO') {
            $this->db->begin();
            $solicitud->setSolicitudturnoRespuestachequeada(1);
            if (!$solicitud->update()) {
                $this->flash->error("OCURRIO UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.");
                $this->db->rollback();
            } else {
                $this->flash->notice("<h1>GRACIAS POR SU CONFIRMACIÓN </h1>");
                $this->db->commit();
            }
        }
        return $this->redireccionar('turnos/resultadoConfirmacion');
    }

    /**
     * Generar numero aleatorio.
     * @return string
     */
    private function getRandomCode($periodo_id)
    {
        $codigo = "";
        $continuar = true;
        while ($continuar) {
            $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $su = strlen($an) - 1;
            $codigo = substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);

            $solicitudes = Solicitudturno::findFirst(
                array('solicitudTurnos_fechasTurnos=:periodo_id: AND solicitudTurno_codigo LIKE :codigo:',
                    'bind' => array('periodo_id' => $periodo_id, 'codigo' => '%' . $codigo . '%')));
            if (!$solicitudes)
                $continuar = false;
        }
        return $codigo;
    }

    /**
     * Proviene de confirma Email. Muestra el resultado de la confirmacion.
     */
    public function resultadoConfirmacionAction()
    {

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

    /**
     * No lo utilizo en turno respondidos.
     */
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
        $this->view->formulario = new PeriodoSolicitudForm($unaFechaTurno, array('editar' => true));
        $this->view->idPeriodo = $idFechaTurno;
    }

    /**
     * Guarda los datos editados del periodo. Update.
     * @return null
     */
    public function guardarDatosEdicionPeriodoAction()
    {
        if (!$this->request->isPost()) {
            return $this->redireccionar('turnos/verPeriodos');
        }

        $id = $this->request->getPost('fechasTurnos_id', 'int');
        $unPeriodo = Fechasturnos::findFirst(array('fechasTurnos_id=:fechasTurnos_id:', 'bind' => array('fechasTurnos_id' => $id)));
        if (!$unPeriodo) {
            $this->flash->message('problema', "NO SE ENCONTRÓ EL PERIODO A EDITAR");
            return $this->redireccionar('turnos/verPeriodos');
        }

        $periodoSolicitudForm = new PeriodoSolicitudForm();
        $this->view->formulario = $periodoSolicitudForm;
        $data = $this->request->getPost();

        if ($periodoSolicitudForm->isValid($data, $unPeriodo) == false) {
            foreach ($periodoSolicitudForm->getMessages() as $mensaje) {
                $this->flash->message('problema', $mensaje);
            }
            return $this->redireccionar('turnos/editarPeriodo/' . $id);
        }
        $this->db->begin();

        if ($unPeriodo->save() == false) {
            foreach ($unPeriodo->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->db->rollback();
            return $this->redireccionar('turnos/editarPeriodo/' . $id);
        }
        $band = $this->programarTableroPeriodo($this->request->getPost('fechasTurnos_inicioSolicitud'), $this->request->getPost('fechasTurnos_finSolicitud'));
        if (!$band) {
            $this->db->rollback();
            $this->flash->message('problema', "SURGIÓ UN PROBLEMA AL INSERTAR UN NUEVO PUNTO PROGRAMADO");
            return $this->redireccionar('turnos/editarPeriodo/' . $id);
        }
        $periodoSolicitudForm->clear();
        $this->flash->message('exito', "ACTUALIZACIÓN EXITOSA");
        $this->db->commit();
        return $this->redireccionar('turnos/verPeriodos');
    }

    /**
     * Setea la tabla schedule con los datos del periodo.
     * @param $desde
     * @param $hasta
     * @return bool
     */
    private function programarTableroPeriodo($desde, $hasta)
    {
        $retorno = false;
        $this->db->begin();
        $schedule = $this->getDi()->get('schedule');
        $puntoProgramado = $schedule->getByType('plazo')->getLast();
        $puntoProgramado->setStart($desde);
        $new_time = date('Y-m-d H:i:s', strtotime($hasta) + 82800);//Le seteo a la fecha final las 23:00:00
        $puntoProgramado->setEnd($new_time);
        if (!$puntoProgramado->update()) {
            $this->db->rollback();
        } else {
            $this->db->commit();
            $retorno = true;
        }
        return $retorno;
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

        $this->assets->collection('headerCss')->addCss("plugins/multiscroll/jquery.multiscroll.css")
            ->addCss("css/individual.css");
        $this->assets->collection('footer')->addJs("plugins/multiscroll/vendors/jquery.easings.min.js")
            ->addJs("plugins/multiscroll/jquery.multiscroll.min.js");
        $this->assets->collection('footerInline')->addInlineJs("
         $(document).ready(function() {
            $('#contenedor-presentacion').multiscroll({
            	sectionsColor: ['#2b8dd6', '#1BBC9B', '#2b8dd6'],
            	anchors: ['first', 'second', 'third'],
            	menu: '#menu',
                navigation: true,
            	navigationTooltips: ['Presentación', 'Guia Online', 'Guia Presencial'],
            	css3: 'true',
            	paddingTop: '70px',
            	paddingBottom: '70px'
            });
        });");
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
        $rangoJs = "";
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo = 1'));
        if ($ultimoPeriodo) {
            $fechasSolicitud = TipoFecha::devolverTodosLosDiasEntreFechas($ultimoPeriodo->getFechasturnosIniciosolicitud(), $ultimoPeriodo->getFechasturnosFinsolicitud());
            $rangoJs = "[";
            foreach ($fechasSolicitud as $dia) {
                $rangoJs .= "{date:'$dia','value':'Periodo para SOLICITAR Turno','estilo':'    border: 2px solid green !important;'},";
            }
            $fechasAtencion = TipoFecha::devolverTodosLosDiasEntreFechas($ultimoPeriodo->getFechasturnosDiaatencion(), $ultimoPeriodo->getFechasturnosDiaatencionfinal());
            foreach ($fechasAtencion as $dia) {
                $rangoJs .= "{date:'$dia','value':'Periodo para ATENCIÓN Turno','estilo':' border: 2px solid orange !important;'},";
            }
            $rangoJs .= "]";
        }
        if ($rangoJs == "")
            return $this->flash->error("<h3>POR EL MOMENTO NO HAY NINGÚN PERÍODO DISPONIBLE</h3>");

        $this->assets->collection('footerInline')->addInlineJs("$('#ca').calendar({
                    // view: 'month',
                    width: 320,
                    height: 320,
                    // startWeek: 0,
                    // selectedRang: [new Date(), null],
                    customClass:'',
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
    public function buscarTurnoAction()
    {
        $this->tag->setTitle('Buscar Turno');
        $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
        if (!$ultimoPeriodo) {
            $this->flash->error("EL PERIODO PARA LOS TURNOS ONLINE NO SE ENCUENTRA HABILITADO.");
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
    public function miTurnoAction()
    {
        $this->tag->setTitle('Mi Turno');

        if (!$this->request->isPost()) {
            return $this->redireccionar('turnos/buscarTurno');
        }

        if (!$this->request->hasPost('legajo') || $this->request->getPost('legajo', 'int') == null) {
            $this->flash->error('INGRESE EL LEGAJO');
        }

        if (!$this->request->hasPost('codigo') || $this->request->getPost('codigo', 'alphanum') == null) {
            $this->flash->error('INGRESE EL CODIGO');
        }
        $legajo = $this->request->getPost('legajo', 'int');
        $codigo = $this->request->getPost('codigo', 'alphanum');
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_legajo=:legajo: AND
         solicitudTurno_codigo=:codigo: ',
            'bind' => array('legajo' => $legajo, 'codigo' => $codigo)));
        if (!$solicitudTurno) {
            $this->flash->error('NO SE HA ENCONTRADO EL TURNO ASOCIADO CON LOS DATOS INGRESADO');
            return $this->redireccionar('turnos/buscarTurno');
        }
        if ($solicitudTurno->getSolicitudturnoCancelado() == 1) {
            $this->flash->error('<h3>EL TURNO CON EL CODIGO <ins>' . $codigo . '</ins> SE ENCUENTRA CANCELADO.
            <br> POR CUALQUIER CONSULTA PUEDE LLAMARNOS AL (0299) 4433978 Int 10</h3>');
            return $this->redireccionar('turnos/buscarTurno');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo = 1 AND fechasTurnos_id=:id:',
            'bind' => array('id' => $solicitudTurno->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $retorno['mensaje'] = "EL PERIODO EN EL CUAL SACO SU TURNO HA FINALIZADO.";
            echo json_encode($retorno);
            return;
        }
        $this->view->legajo = $legajo;
        $this->view->codigo = $codigo;
        $this->view->apeNombre = $solicitudTurno->getSolicitudturnoNomape();
        $this->view->solicitud_id = $solicitudTurno->getSolicitudturnoId();
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        $codigo = substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
        $this->view->codigoSeguridad = $codigo;

    }

    /**
     * Cancela un turno en particular mediante ajax.
     */
    public function cancelarTurnoAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        if (!$this->request->isPost()) {
            return $this->redireccionar('turnos/buscarTurno');
        }
        if (strtoupper($this->request->getPost('codigoSeguridad')) != strtoupper($this->request->getPost('codigoRepetido'))) {
            $retorno['mensaje'] = "EL Código de seguridad no coincide, vuelva a intentarlo nuevamente";
            echo json_encode($retorno);
            return;
        }
        if (!$this->request->hasPost('legajo') || $this->request->getPost('legajo', 'int') == null) {
            $retorno['mensaje'] = "Hubo un problema al encontrar el legajo, realice los pasos nuevamente.";
            echo json_encode($retorno);
            return;
        }

        if (!$this->request->hasPost('codigo') || $this->request->getPost('codigo', 'alphanum') == null) {
            $retorno['mensaje'] = "Hubo un problema al encontrar el código de operación, realice los pasos nuevamente.";
            echo json_encode($retorno);
            return;
        }
        $legajo = $this->request->getPost('legajo', 'int');
        $codigo = $this->request->getPost('codigo', 'alphanum');
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_legajo=:legajo: AND
         solicitudTurno_codigo=:codigo: ',
            'bind' => array('legajo' => $legajo, 'codigo' => $codigo)));
        if (!$solicitudTurno) {
            $retorno['mensaje'] = 'NO SE HA ENCONTRADO EL TURNO ASOCIADO CON LOS DATOS INGRESADO';
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoCancelado() == 1) {
            $retorno['mensaje'] = 'El turno ya fue cancelado. <br> Redireccionando...';
            $retorno['success'] = true;//Para que redireccione
            echo json_encode($retorno);
            return;
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo = 1 AND fechasTurnos_id=:id:',
            'bind' => array('id' => $solicitudTurno->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $retorno['mensaje'] = "EL PERIODO PARA CANCELAR LOS TURNOS HA FINALIZADO.";
            echo json_encode($retorno);
            return;
        }
        $this->db->begin();
        //FIXME: TERMINAR VERIFICAR DENTRO DE 48HS...
        if (!Fechasturnos::verificaCancelacionDentro48Hs()) {
            $solicitudTurno->setSolicitudturnoSanciones($solicitudTurno->getSolicitudturnoSanciones() + 1);
            $retorno['mensaje'] = "Se ha registrado una sanción porque la cancelación no se realizó antes de las 48hs al período de atención. <br> Por cualquier consulta puede llamarnos al (0299) 4433978 Int 10";
        }
        $solicitudTurno->setSolicitudturnoCancelado(1);
        if (!$solicitudTurno->update()) {
            $retorno['mensaje'] = 'Ocurrio un problema al deshabilitar el turno';
            $this->db->rollback();
            echo json_encode($retorno);
            return;
        }
        $ultimoPeriodo->setFechasturnosCantidadautorizados($ultimoPeriodo->getFechasturnosCantidadautorizados() - 1);
        $ultimoPeriodo->setFechasturnosSinturnos(0);//No hace falta preguntar si esta en 0 o en 1.
        if (!$ultimoPeriodo->update()) {
            $retorno['mensaje'] = 'Ocurrió un problema al deshabilitar el turno. Periodo no actualizado.';
            $this->db->rollback();
            echo json_encode($retorno);
            return;
        }
        $this->db->commit();
        $retorno['mensaje'] .= " <br> El turno se ha cancelado correctamente.";
        $retorno['success'] = true;

        echo json_encode($retorno);
        return;
    }
    public function confirmarRespuestaAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        if($this->request->getPost('solicitudTurno_id')==null)
        {
            $retorno['mensaje'] = "OCURRIÓ UN PROBLEMA, NO SE PUDO ACTUALIZAR LA SOLICITUD DE TURNO.";
            echo json_encode($retorno);
            return;
        }
        if($this->request->getPost('solicitudTurno_legajo')==null)
        {
            $retorno['mensaje'] = "OCURRIÓ UN PROBLEMA, NO SE PUDO RECUPERAR EL LEGAJO.";
            echo json_encode($retorno);
            return;
        }

        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id: AND
                        solicitudTurno_legajo=:solicitudTurno_legajo: ',
            'bind'=>array('solicitudTurno_id'=>$this->request->getPost('solicitudTurno_id'),
                            'solicitudTurno_legajo'=>$this->request->getPost('solicitudTurno_legajo'))));
        if(!$solicitudTurno)
        {
            $retorno['mensaje'] = "OCURRIÓ UN PROBLEMA, NO SE ENCONTRÓ LA SOLICITUD.".$this->request->getPost('solicitudTurno_id');
            echo json_encode($retorno);
            return;
        }

        $solicitudTurno->setSolicitudturnoRespuestachequeada(1);
        if(!$solicitudTurno->update())
        {
            $retorno['mensaje'] = "OCURRIÓ UN PROBLEMA, NO SE PUDO ACTUALIZAR LA SOLICITUD.";
            echo json_encode($retorno);
            return;
        }
        $retorno['mensaje'] = "OPERACIÓN EXITOSA, LA SOLICITUD DE TURNO HA SIDO ACTUALIZADA.";
        $retorno['success']=true;
        echo json_encode($retorno);
        return;


    }

}



