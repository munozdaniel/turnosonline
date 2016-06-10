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

    private function cantCeros($valor)
    {
        switch ($valor) {
            case 1:
                $cad = '0';
                break;
            case 2:
                $cad = '00';
                break;
            case 3:
                $cad = '000';
                break;
            case 4:
                $cad = '0000';
                break;
        }

        return $cad;
    }

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
        $legajo = $this->request->getPost('solicitudTurno_legajo');
        $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
        $nombre = rtrim($nombre);
        $nombre = ltrim($nombre);
        $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
        $apellido = rtrim($apellido);
        $apellido = ltrim($apellido);
        $documento = $this->request->getPost('solicitudTurno_documento');
        $numTelefono = $this->request->getPost('solicitudTurno_numTelefono');
        $email = $this->request->getPost('solicitudTurno_email', array('email', 'trim', 'upper'));

        //verificar cantidad de digitos del legajo

        $cant = strlen($legajo);
        if ($cant < 6)
            $legajo = $this->cantCeros(6 - $cant) . $legajo;

        //3. verifica si los datos ingresados pertenecen a un afiliado de siprea
        $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido);

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
        $this->flash->notice('<div align="left">
                                <h1>
                                <i class="fa fa-info-circle fa-3x pull-left" style="display: inline-block;"></i>
                                    LA SOLICITUD FUE INGRESADA CORRECTAMENTE
                                </h1>
                                <h3>
                                    Cuando nuestros empleados finalicen con el análisis de su estado
                                    de deuda se le enviará un correo electrónico para que confirme su asistencia.
                                </h3>
                                </div>  ');
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
                "bind" => array("fechasTurnos_id" => $ultimoPeriodo->fechasTurnos_id, "email" => trim($email)))
        );
        if ($solicitud)
            return true;
        else
            return false;
    }

    /**
     * Verifica que los datos ingresados por parametros se encuentren en la bd de siprea.
     * @param $legajo int corresponde al legajo del afiliado.
     * @param $nombreCompleto String corresponde a los apellidos concatenados con los nombres, separados por espacio.
     * No es necesario que este completo.
     * @return bool|string
     */
    private function comprobarDatosEnSiprea($legajo, $apellido)
    {
        try {
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom
                      FROM siprea2.afiliados AS AF
                       WHERE (AF.afiliado_apenom LIKE '%" . $apellido . "%')
                       AND (AF.afiliado_legajo like '" . $legajo . "')
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

                $fechasTurnos_inicioSolicitud = $this->request->getPost('fechasTurnos_inicioSolicitud');
                $periodoSolicitudHasta = $this->request->getPost('fechasTurnos_finSolicitud');
                $periodoDiaAtencion = $this->request->getPost('fechasTurnos_diaAtencion');
                $periodoDiaAtencionFinal = $this->request->getPost('fechasTurnos_diaAtencionFinal');

                $fechaVencimiento = TipoFecha::sumarDiasAlDate(7, $periodoSolicitudHasta);

                if ($fechaVencimiento < $periodoDiaAtencion) {
                    $fechasTurnos = new Fechasturnos();
                    $fechasTurnos->assign(array(
                        'fechasTurnos_inicioSolicitud' => $fechasTurnos_inicioSolicitud,
                        'fechasTurnos_finSolicitud' => $periodoSolicitudHasta,
                        'fechasTurnos_diaAtencion' => $periodoDiaAtencion,
                        'fechasTurnos_diaAtencionFinal' => $periodoDiaAtencionFinal,
                        'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('fechasTurnos_cantidadDeTurnos', 'int'),
                        'fechasTurnos_cantidadAutorizados' => 0,
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
                } else
                    $this->flash->message('problema', "Deberá modificar el <ins>periodo de atención de turnos</ins> para que el afiliado tenga tiempo de <strong>confirmar el mensaje</strong>.");
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
        if (Fechasturnos::verificaSiHayTurnos($ultimoPeriodo)) {
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
                        $solicitudTurno->setSolicitudturnoEstado('DENEGADO POR FALTA DE TURNOS');
                        $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('solicitudTurno_observaciones', array('string')));
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('Y-m-d H:i:s'));
                    } else {
                        Fechasturnos::incrementarCantAutorizados();
                        $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('solicitudTurno_observaciones', array('string')));
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('Y-m-d H:i:s'));
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
                    if ($estadoNuevo == "REVISION" || $estadoNuevo == "AUTORIZADO") {
                        $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('solicitudTurno_observaciones', array('string')));
                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('Y-m-d H:i:s'));
                    } else {
                        if ($estadoNuevo == "DENEGADO")
                            $solicitudTurno->setSolicitudturnoObservaciones($this->request->getPost('causa'));
                        else
                            $solicitudTurno->setSolicitudturnoObservaciones("-");

                        $solicitudTurno->setSolicitudTurnoNickUsuario($this->session->get('auth')['usuario_nick']);
                        $solicitudTurno->setSolicitudturnoFechaprocesamiento(Date('Y-m-d H:i:s'));
                    }
                }

                if ($solicitudTurno->update()) {
                    $this->response->setJsonContent(array("res" => "success",
                        "data" => array("cantidadAutorizados" => $ultimoPeriodo->getFechasturnosCantidadautorizados(),
                            "cantidadTurnos" => $ultimoPeriodo->getFechasturnosCantidaddeturnos())));
                    $this->response->setStatusCode(200, "OK");
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
            $this->flash->error("<h1>NO HAY NINGÚN PERIODO DISPONIBLE.</h1>");
            $this->flash->notice($this->tag->linkTo(array('turnos/calendario', "<h1><i class='fa fa-calendar'></i> CONSULTAR CALENDARIO.</h1>", 'class' => 'text-decoration-none ')));
            return $this->redireccionar('administrar/index');

        }
        //Verifificamos si el plazo para solicitar turnos venció.
        if (!$ultimoPeriodo->esPlazoParaSolicitarTurno()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> EL PERIODO PARA SOLICITAR TURNOS NO ESTÁ HABILITADO.</h3>');
        }
        //verificamos si hay turnos disponibles.
        if (!$ultimoPeriodo->hayTurnosDisponibles()) {
            $this->flash->message('dismiss', '<h3> <i class="fa fa-info-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">X</span>
                                            </button> NO HAY TURNOS DISPONIBLES.</h3>');
        }
        $info = array();
        $info['cantidadAutorizados'] = $ultimoPeriodo->getFechasturnosCantidadautorizados();
        $info['cantidadTurnos'] = $ultimoPeriodo->getFechasturnosCantidaddeturnos();
        $info['fechaInicio'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosIniciosolicitud()));
        $info['fechaFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosFinsolicitud()));
        $info['diaAtencion'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencion()));
        $info['diaAtencionFinal'] = date('d/m/Y', strtotime($ultimoPeriodo->getFechasturnosDiaatencionfinal()));
        $this->view->informacion = $info;


        if (Fechasturnos::verificaSiHayTurnos($ultimoPeriodo)) {
            $this->view->rojo = true;
        } else {
            $this->view->rojo = false;
        }
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

        if ($fechaTurnos) {
            $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id:',
                'bind' => array('fechasTurnos_id' => $fechaTurnos->getFechasturnosId()),
                'order' => 'solicitudTurno_fechaRespuestaEnviada ASC'));

            foreach ($solicitudes as $unaSolicitud) {
                if ($unaSolicitud->getSolicitudturnoRespuestaenviada() == 'SI') {
                    $item = array();
                    //0 ID: Se utiliza para aceptar/cancelar asistencia
                    $item[] = $unaSolicitud->getSolicitudturnoId();
                    //1 Tipo de Turno: para pintar la fila de rojo
                    $item[] = $unaSolicitud->getSolicitudturnoEstadoasistenciaid();
                    //2 Codigo
                    $item[] = $unaSolicitud->getSolicitudturnoCodigo();
                    //3 Afiliado
                    $item[] = '<h4><ins>' . $unaSolicitud->getSolicitudturnoLegajo() . ' </ins></h4>' . $unaSolicitud->getSolicitudturnoNomape();
                    //4 Email/Telefono
                    if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                        $email = '';
                    else
                        $email = "" . $unaSolicitud->getSolicitudturnoEmail();
                    $item[] = "<i class='fa fa-envelope-o'></i> " . $email . " <br> <i class='fa fa-phone-square'></i> " . $unaSolicitud->getSolicitudturnoNumtelefono();
                    //5 FechaRespuestaEnviada
                    $item[] = (new DateTime($unaSolicitud->getSolicitudturnoFecharespuestaenviada()))->format('d/m/Y');

                    $botonesAsistencia = "";
                    $estadoAsistencia = "";
                    $comprobante = "";
                    $colorComprobante = "";
                    $idCodificado = base64_encode($unaSolicitud->getSolicitudturnoId());
                    if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 1) {//Online
                        $colorComprobante = "btn btn-info btn-block";
                        $comprobante = '<a class=\'' . $colorComprobante . '\'> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong></a>';
                    } else {
                        if ($unaSolicitud->getSolicitudturnoTipoturnoid() == 2) {//Terminal
                            $colorComprobante = "btn btn-success btn-block";
                            $comprobante = '<a class=\'' . $colorComprobante . '\'> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong></a>';
                        }
                    }
                    //Controlo si las respuesta se vencio
                    if ($unaSolicitud->getSolicitudturnoEstado() == "AUTORIZADO") {


                        switch ($unaSolicitud->getSolicitudturnoEstadoasistenciaid()) {
                            case 1://En Espera
                                $estadoAsistencia = '<div class="btn-block" align="center">' .
                                    '<a class="parpadea btn btn-white" style="display:inline-block;">
                                        <i class="fa fa-spinner fa-spin  fa-fw margin-bottom"></i>
                                            <span class="sr-only">Cargando...</span>EN ESPERA</a></div>';
                                $botonesAsistencia = '<div class="btn-block" align="center">' .
                                    '<a id="acepta"  class=" btn btn-gris"> <i class="fa fa-check"></i> ACEPTAR </a> ' .
                                    '<a id="cancela" class=" btn btn-danger" ><em> <i class="fa fa-times"></i> CANCELAR</em></i></a>' .
                                    '</div>';
                                break;
                            case 2://Confirmado
                                $estadoAsistencia = '<a class="btn btn- btn-white">
                                                        <i class="fa fa-check-square" style="display:inline-block;color:#0ec705"></i> '
                                    . "CONFIRMADO  </a>";
                                $botonesAsistencia = '<div class="btn-block" align="center">' .
                                    '<a id="cancela" class=" btn btn-danger" ><em> <i class="fa fa-times"></i> CANCELAR</em></i></a>' .
                                    '</div>';
                                $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado,
                                    '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ',
                                    'class' => "$colorComprobante", 'target' => '_blank'));
                                break;
                            case 3://Vencido
                                $estadoAsistencia = '<a class="btn btn-block btn-white">
                                                <i class="fa fa-ban text-danger"></i>
                                                ' . "PLAZO VENCIDO</a>";
                                break;
                            case 4://Cancelado
                                $estadoAsistencia = '<a class="btn btn-block btn-white">
                                                <i class="fa fa-ban text-danger"></i>
                                                ' . "CANCELADO</a>";
                                break;
                        }
                    }

                    //6 Usuario
                    $item[] = $unaSolicitud->getSolicitudturnoNickusuario();
                    //7 Estado Deuda: Autorizado, denegado, denegado por falta de turno
                    $item[] = $unaSolicitud->getSolicitudturnoEstado();
                    //8 Observaciones
                    $item[] = $unaSolicitud->getSolicitudturnoObservaciones();
                    //9 Estado Asistencia
                    $item[] = $estadoAsistencia;
                    //10 Botones par cancelar/Autorizar asistencia
                    $item[] = $botonesAsistencia;
                    //11 Comprobante
                    $item[] = $comprobante;
                    $datos[] = $item;
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


        if (Fechasturnos::verificaSiHayTurnos($ultimoPeriodo)) {
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

        /*$phql = "SELECT MAX(fechasTurnos_id) AS ultimoPeriodo FROM Fechasturnos";
        $rows = $this->modelsManager->executeQuery($phql);
        foreach ($rows as $row) {
            $fechaTurnos_id = $row["ultimoPeriodo"];
        }
        $retorno['prueba'] = $fechaTurnos_id;
        $fechaTurnos = Fechasturnos::findFirst(array('fechasTurnos_id=' . $fechaTurnos_id));//Obtengo el periodo activo.*/
        $fechaTurnos = Fechasturnos::findFirst(array('fechasTurnos_activo=1'));//Obtengo el periodo activo.


        if ($fechaTurnos) {
            $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id: AND solicitudTurno_estadoAsistenciaId=4',
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
                    $idCodificado = base64_encode($unaSolicitud->getSolicitudturnoId());

                    $respondio = '<i class="fa fa-check-square" style="color:#0ec705"></i> ' . $unaSolicitud->getEstadoasistencia()->getEstadoasistenciaNombre();
                    $comprobante = $this->tag->linkTo(array('turnos/comprobanteTurno/?id=' . $idCodificado
                    , '<i class="fa fa-print pull-left"></i> <strong>' . $unaSolicitud->getTipoturno()->getTipoturnoNombre() . '</strong> ', 'class' => 'btn btn-info btn-block', 'target' => '_blank'));


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
     * Acepta la asistencia
     */
    public function aceptaAsistenciaAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = "";
        if ($this->request->getPost('solicitudTurno_id') == ""
            || $this->request->getPost('solicitudTurno_id') == NULL
        ) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el Identificador del turno solicitado.
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ".$this->request->getPost('solicitudTurno_id') ;
            echo json_encode($retorno);
            return;
        }
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id:', 'bind' =>
            array('solicitudTurno_id' => base64_decode($this->request->getPost('solicitudTurno_id')))));
        if (!$solicitudTurno) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el turno solicitado.<hr>
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 2) {
            $retorno['mensaje'] = "El turno seleccionado ya ha sido confirmado.";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 3) {
            $retorno['mensaje'] = "El turno seleccionado no puede ser confirmado, ya que venció el plazo disponible.";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 4) {
            $retorno['mensaje'] = "El turno seleccionado ya fue cancelado, el afiliado deberá solicitar un nuevo turno.";
            echo json_encode($retorno);
            return;
        }
        $dentroPlazoValido = true;
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 1) {
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
            else
                if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2)
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
            if (!$dentroPlazoValido) {
                //FIXME: Deberia acumular la sancion el evento de mysql
                $retorno['mensaje'] = "El plazo para confirmar el turno ha finalizado. <hr> Se ha acumulado una sanción. ";
                echo json_encode($retorno);
                return;
            }
            $periodo = Fechasturnos::findFirst(array('fechasTurnos_id=:solicitudTurno_fechasTurnos:',
                'bind' => array('solicitudTurno_fechasTurnos' => $solicitudTurno->getSolicitudturnosFechasturnos())));

            $this->db->begin();
            $solicitudTurno->setSolicitudturnoFechaconfirmacion(date('Y-m-d'));
            $solicitudTurno->setSolicitudturnoEstadoasistenciaid(2);//Confirmado
            $mensajeCodigo = "";
            if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
                if ($solicitudTurno->getSolicitudturnoCodigo() == null || trim($solicitudTurno->getSolicitudturnoCodigo()) == "") {
                    $codigo = $this->getRandomCode($periodo->getFechasTurnosId());
                    $solicitudTurno->setSolicitudturnoCodigo($codigo);
                }
                $mensajeCodigo = " <ins>Código</ins>: <strong class='strong-azul font-gotham' style='letter-spacing: 0.3em; font-size:22px;'> " . $solicitudTurno->getSolicitudturnoCodigo() . "</strong>";
                $mensajeCodigo .= "<br><br> <ins>Afiliado</ins>: <strong> " . $solicitudTurno->getSolicitudturnoNomape() . "</strong>";
                $mensajeCodigo .= "<br><br> <ins>Fecha de Atención</ins>: <strong> " . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencion())) . "</strong> al <strong>" . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencionfinal())) . "</strong>";
            }

            if (!$solicitudTurno->update()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos. <hr> Inténtelo nuevamente, en caso
                de que el problema persista comuníquese con el <strong>Soporte Técnico</strong>.";
                echo json_encode($retorno);
                return;
            }
        }
        $this->db->commit();
        $retorno['success'] = true;
        $retorno['mensaje'] = $mensajeCodigo;
        echo json_encode($retorno);
        return;
    }

    /**
     * Cancela la asistencia
     */
    public function cancelaAsistenciaAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = "";
        if ($this->request->getPost('solicitudTurno_id') == ""
            || $this->request->getPost('solicitudTurno_id') == NULL
        ) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el <strong>IDentificador </strong> del turno solicitado.
             <hr> Por favor intenteló nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:solicitudTurno_id:', 'bind' =>
            array('solicitudTurno_id' => base64_decode($this->request->getPost('solicitudTurno_id')))));
        if (!$solicitudTurno) {
            $retorno['mensaje'] = "Ocurrió un problema, no se encontró el turno solicitado.
             Por favor inténtelo nuevamente, en caso que el problema persista comuníquese con Soporte Técnico.  ";
            echo json_encode($retorno);
            return;
        }
        $dentroPlazoValido = true;
        //Lo deberia hacer el evento de mysql
        if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1)
            $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
        else
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
        if (!$dentroPlazoValido) {
            //FIXME: Deberia acumular la sancion el evento de mysql
            $retorno['mensaje'] = "El plazo para confirmar el turno ha finalizado. <hr> Se ha acumulado una sanción. ";
            echo json_encode($retorno);
            return;
        }
        if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
            //Se libera un turno
            $periodo = Fechasturnos::findFirst(array('fechasTurnos_id=:solicitudTurno_fechasTurnos:',
                'bind' => array('solicitudTurno_fechasTurnos' => $solicitudTurno->getSolicitudturnosFechasturnos())));

            $this->db->begin();
            $solicitudTurno->setSolicitudturnoEstadoasistenciaid(4);
            if (!$periodo->decrementarCantAutorizados()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos con respecto a los turnos autorizados. <hr> Inténtelo nuevamente, en caso
                de que el problema persista comuníquese con el <strong>Soporte Técnico</strong>.";
                echo json_encode($retorno);
                return;
            }
            if (!$solicitudTurno->update()) {
                $this->db->rollback();
                $retorno['mensaje'] = "Ha ocurrido un error, no se pudieron actualizar los datos. Inténtelo nuevamente, en caso
            de que el problema persista comuníquese con el Soporte Técnico.";
                echo json_encode($retorno);
                return;
            }
            $mensajeCodigo = "<br> <ins>Afiliado</ins>: <strong> " . $solicitudTurno->getSolicitudturnoNomape() . "</strong>";
            $mensajeCodigo .= "<br> <ins>Fecha de Atención</ins>: <strong> " . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencion())) . "</strong> al <strong>" . date('d/m/Y', strtotime($periodo->getFechasturnosDiaatencionfinal())) . "</strong>";

        }
        $this->db->commit();
        $retorno['success'] = true;
        $retorno['mensaje'] = $mensajeCodigo;
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
//------------------------------------
    /**
     * Verifica quien tiene correo, y se le envia una respuesta.
     * Si es autorizado se lo pone en espera.
     */
    public function enviarRespuestasAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = "";
        $retorno['errores'] = "";
        set_time_limit(300);
        $usuarioActual = $this->session->get('auth')['usuario_nick'];
        $ultimoPeriodo = Fechasturnos::findFirst("fechasTurnos_activo=1");

        $solicitudes = Solicitudturno::find(array(
            "solicitudTurno_respuestaEnviada LIKE 'NO'
            AND solicitudTurno_nickUsuario LIKE :usuario:
            AND solicitudTurnos_fechasTurnos=:periodo_id:
            AND solicitudTurno_estado  NOT LIKE 'PENDIENTE'
            AND solicitudTurno_estado NOT LIKE 'REVISION'",
            "bind" => array(
                'usuario' => $usuarioActual,
                'periodo_id' => $ultimoPeriodo->getFechasturnosId()
            )
        ));
        if (count($solicitudes) == 0) {
            $retorno['mensaje'] = count($solicitudes) . "No es posible enviar las respuestas, ya que no hay solicitudes que se hayan autorizado o denegado.";
            echo json_encode($retorno);
            return;
        }
        $fechaAtencion = TipoFecha::fechaEnLetras($ultimoPeriodo->getFechasturnosDiaatencion());
        $fechaAtencionFinal = TipoFecha::fechaEnLetras($ultimoPeriodo->getFechasturnosDiaatencionfinal());
        $mensajeAutorizado = "Su solicitud ha sido <b>AUTORIZADA</b>. Deberá acercarse a nuestra institución entre los días <b>$fechaAtencion y $fechaAtencionFinal</b> para realizar el trámite.";
        $mensajeDenegado = "Su solicitud ha sido <b>DENEGADA</b> debido a que ";
        $mensajeDenegadoFT = "Los turnos correspondientes al mes en curso ya han sido otorgados en su totalidad. Le sugerimos solicitar un turno en el <b> periodo siguiente </b>.";
        $afiliados = "";
        $errorMail = "";
        foreach ($solicitudes as $solicitud) {
            $this->db->begin();
            $solicitud->setSolicitudturnoRespuestaenviada('SI');
            $solicitud->setSolicitudturnoFecharespuestaenviada(date('Y-m-d H:i:s'));
            if ($solicitud->getSolicitudturnoEstado() == "AUTORIZADO") {
                $solicitud->setSolicitudturnoEstadoasistenciaid(1);//EN ESPERA
            } else {
                $solicitud->setSolicitudturnoEstadoasistenciaid(5);//NO DEBE ASISTIR
            }
            if (!$solicitud->update()) {
                $this->db->rollback();
                $afiliados .= "<li>" . $solicitud->getSolicitudturnoNomape() . "</li>";
            } else {
                $template = "";
                if (trim($solicitud->getSolicitudturnoEmail()) != "" && $solicitud->getSolicitudturnoEmail() != NULL) {
                    try {
                        $this->mailDesarrollo->addAddress($solicitud->getSolicitudturnoEmail(), $solicitud->getSolicitudturnoNomape());
                        $this->mailDesarrollo->Subject = "Respuesta por solicitud de un turno en IMPS WEB";
                        if ($solicitud->getSolicitudturnoEstado() == "AUTORIZADO") {
                            $template = $this->seleccionarTemplateAutorizado($solicitud, $mensajeAutorizado);
                        } else {
                            if ($solicitud->getSolicitudturnoEstado() == "DENEGADO") {
                                $template = $this->seleccionarTemplateDenegado($solicitud, $mensajeDenegado);
                            } else {
                                if ($solicitud->getSolicitudturnoEstado() == "DENEGADO POR FALTA DE TURNOS") {
                                    $template = $this->seleccionarTemplateDenegado($solicitud, $mensajeDenegadoFT);
                                }
                            }
                        }
                        $this->mailDesarrollo->MsgHTML($template);
                        $this->mailDesarrollo->body = strip_tags($template);
                        $band = $this->mailDesarrollo->send();
                        if (!$band) {
                            $afiliados .= "<li>" . $solicitud->getSolicitudturnoNomape() . "</li>";
                            $errorMail .= $this->mailDesarrollo->ErrorInfo . "<br>";
                            $this->db->rollback();
                        } else {
                            $this->db->commit();//Se envió el correo,por lo tanto actualizo los datos.
                        }
                        $this->mailDesarrollo->clearAddresses();
                    } catch (phpmailerException $e) {
                        $errorMail .= $e->errorMessage(); //Pretty error messages from PHPMailer
                    } catch (Exception $e) {
                        $errorMail .= $e->getMessage() . " - " . $e->getTraceAsString(); //Boring error messages from anything else!
                    }
                } else {
                    $this->db->commit();//Se envió el correo,por lo tanto actualizo los datos.

                }
            }
        }
        $retorno['success'] = true;
        $retorno['mensaje'] = "Las respuestas fueron enviadas a los afiliados.";
        if (trim($afiliados) != "")
            $retorno['mensaje'] .= '<ul> Los siguientes afiliados no pudieron ser avisados por correo:  <br>' . $afiliados . '</ul>';
        if ($errorMail != "")
            $retorno['mensaje'] .= 'Ocurrió un problema al enviar los correos, por favor comuníquese con Soporte Técnico.  <br>' . $afiliados . '<br> [ ' . $errorMail . ' ]';
        echo json_encode($retorno);
        return;
    }


    private function seleccionarTemplateAutorizado($solicitud, $mensaje)
    {
        $solicitudTurno_id = $solicitud->getSolicitudturnoId();
        $idCodificado = base64_encode($solicitudTurno_id);
        $correo = $solicitud->getSolicitudturnoEmail();
        $nomApe = $solicitud->getSolicitudturnoNomape();
        $obs = $solicitud->getSolicitudturnoObservaciones();
        $template = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/files/emailtemplate/autorizado.volt');
        $template = str_replace('%nombreAfiliado%', $nomApe, $template);
        $template = str_replace('%mensaje%', $mensaje, $template);
        //Si es online: tiene 96hs. Si es Terminal: tiene 72hs
        $fechaLimiteConfirmacion = date('d/m/Y');

        if ($solicitud->getSolicitudturnoTipoturnoid() == 1) {
            $fechaLimiteConfirmacion = strtotime('+4 day', strtotime($solicitud->getSolicitudturnoFechapedido()));
            $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
        } else {
            if ($solicitud->getSolicitudturnoTipoturnoid() == 2) {
                $fechaLimiteConfirmacion = strtotime('+3 day', strtotime($solicitud->getSolicitudturnoFechapedido()));
                $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
            }
        }

        $fechaLimiteConfirmacion = TipoFecha::fechaEnLetrasSinAnio($fechaLimiteConfirmacion);

        $mensajeConfirmacion = "Recuerde confirmar éste mensaje hasta el <b>" . $fechaLimiteConfirmacion . "</b> inclusive, caso contrario el turno será cancelado.<br/>";
        $template = str_replace('%mensajeConfirmacion%', $mensajeConfirmacion, $template);
        if ($obs != "-" && trim($obs) != "") {
            $template = str_replace('%observacion%', 'Observación: ' . $obs, $template);
        } else {
            $template = str_replace('%observacion%', '', $template);
        }
        $template = str_replace('%linkConfirmar%', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../turnos/confirmaEmail/?id=' . $idCodificado, $template);
        $template = str_replace('%linkCancelar%', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../turnos/cancelarEmail/?id=' . $idCodificado, $template);
        $template = str_replace('%urlImagenAdvertencia%', 'http://imps.org.ar/impsweb/public/img/emailtemplate/warning.png', $template);
        return $template;
    }

    private function seleccionarTemplateDenegado($solicitud, $mensaje)
    {
        $nomApe = $solicitud->getSolicitudturnoNomape();
        $causa = $solicitud->getSolicitudturnoObservaciones();
        $template = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/files/emailtemplate/denegado.html');
        $template = str_replace('%nombreAfiliado%', $nomApe, $template);
        $template = str_replace('%mensaje%', $mensaje, $template);
        if ($causa != "-" && trim($causa) != "") {
            $causa = "<b>$causa</b>";
            $template = str_replace('%observacion%', strtolower($causa), $template);
        } else {
            $template = str_replace('%observacion%', '', $template);
        }
        return $template;
    }

    /**
     * El afiliado ingresa al link enviado por email y se redirecciona a esta accion.
     * <ul>Controlará que:
     *      <li>exista la solicitud y el periodo activo</li>
     *      <li>Si el estado es denegado: setea respuesta chequeada</li>
     *      <li>
     *          <ul>Si el estado es autorizado:
     *              <li>Verifica si el email ya fue confirmado</li>
     *              <li>Verifica si hay turnos disponibles</li>
     *              <li>Verifica si el plazo de confirmacion vencio</li>
     *              <li>Actualiza los datos de la solicitud</li>
     *          </ul>
     *      </li>
     * </ul>
     */
    public function confirmaEmailAction()
    {
        $idSolicitud = $this->request->get('id', 'trim');//Se obtiene por url.
        $id = base64_decode($idSolicitud);
        $solicitud = Solicitudturno::findFirst(array('solicitudTurno_id=:id:', 'bind' => array('id' => $id)));
        if (!$solicitud) {
            $this->flash->error("<h3>NO SE HA ENCONTRADO LA PETICIÓN SOLICITADA</h3>");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1 AND fechasTurnos_id=:solicitudTurno_id:',
            'bind' => array('solicitudTurno_id' => $solicitud->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> EL LINK HA CADUCADO, EL TURNO A CONFIRMAR NO PERTENECE AL PERIODO ACTIVO <br>
                                POR FAVOR VUELVA A SOLICITAR UN TURNO EN EL PRÓXIMO PERÍODO.  </h3>");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        $estado = $solicitud->getSolicitudturnoEstado();
        $this->db->begin();
        if ($estado == 'AUTORIZADO') {
            //Verifico si venció, según el tipo de turno.
            $dentroPlazoValido = false;
            if ($solicitud->getSolicitudturnoTipoturnoid() == 1)
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitud->getSolicitudturnoFechapedido());
            else
                if ($solicitud->getSolicitudturnoTipoturnoid() == 2)
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitud->getSolicitudturnoFechapedido());
            //Si venció, lo sanciono.
            if (!$dentroPlazoValido) {
                $solicitud->setSolicitudturnoEstadoasistenciaid(3);
                $solicitud->setSolicitudturnoSanciones($solicitud->getSolicitudturnoSanciones() + 1);
                //FIXME: Mostrar las reglas del juego
                if (!$solicitud->update())
                    $this->db->rollback();
                $this->db->commit();
                $this->view->solicitud = NULL;
                $this->flash->error("<h3>LAMENTABLEMENTE SE VENCIÓ EL TIEMPO PARA CONFIRMAR LA ASISTENCIA.</h3>");
                return $this->redireccionar('turnos/resultadoConfirmacion');
            }
            //Esta cancelado
            if ($solicitud->getSolicitudturnoEstadoasistenciaid() == 4) {
                $this->view->solicitud = NULL;
                $this->flash->error("<h3>USTED HA CANCELADO SU ASISTENCIA ANTERIORMENTE, DEBERÁ SOLICITAR UN TURNO NUEVAMENTE. </h3>");
                return $this->redireccionar('turnos/resultadoConfirmacion');
            }
            //No venció, preparo el comprobante y las variables para la vista.
            $idCodificado = base64_encode($solicitud->getSolicitudturnoId());
            $boton = $this->tag->form(array('turnos/comprobanteTurnoPost', 'method' => 'POST'));
            $boton .= $this->tag->hiddenField(array('solicitud_id', 'value' => $idCodificado));
            $boton .= "<button type='submit' class='btn btn-danger btn-lg' formtarget='_blank'><i class='fa fa-print'></i> Imprimir</button>";
            $boton .= "</form>";

            $this->view->solicitud = $solicitud;
            $this->view->periodo = $ultimoPeriodo;
            $this->view->mensaje_boton = $boton;

            //Ya fue confirmado
            if ($solicitud->getSolicitudturnoEstadoasistenciaid() == 2) {
                $this->view->mensaje_alerta = "Su asistencia ya ha sido confirmada";
                return $this->redireccionar('turnos/resultadoConfirmacion');
            }

            //Primera vez que confirma
            $solicitud->setSolicitudturnoEstadoasistenciaid(2);
            $solicitud->setSolicitudturnoFechaconfirmacion(Date('Y-m-d H:i:s'));
            //Si no tiene codigo le genero uno nuevo.
            if ($solicitud->getSolicitudturnoCodigo() == null || trim($solicitud->getSolicitudturnoCodigo()) == "") {
                $codigo = $this->getRandomCode($ultimoPeriodo->getFechasTurnosId());
                $solicitud->setSolicitudturnoCodigo($codigo);
            }
            if (!$solicitud->update()) {
                $this->flash->error("<h3><i class='fa fa-warning'></i> OCURRIÓ UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.</h3>");
                $this->db->rollback();
                return $this->redireccionar('turnos/resultadoConfirmacion');
            }
            if (!$ultimoPeriodo->update()) {
                $this->flash->error("OCURRIO UN PROBLEMA AL PROCESAR LA SOLICITUD, POR FAVOR INTENTELO NUEVAMENTE.");
                $this->db->rollback();
                return $this->redireccionar('turnos/resultadoConfirmacion');
            }
            $this->view->mensaje_alerta = "Gracias por confirmar su asistencia";
            $this->db->commit();
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
    }

    /**
     * Cancelar un turno que proviene por email.
     */
    public function cancelarEmailAction()
    {
        $this->view->titulo = "CANCELAR ASISTENCIA";
        $idSolicitud = $this->request->get('id', 'trim');//Se obtiene por url.
        $id = base64_decode($idSolicitud);
        $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:id:', 'bind' => array('id' => $id)));
        if (!$solicitudTurno) {
            $this->flash->error("<h3>NO SE HA ENCONTRADO LA PETICIÓN SOLICITADA</h3>");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        $ultimoPeriodo = Fechasturnos::findFirst(array('fechasTurnos_activo=1 AND fechasTurnos_id=:solicitudTurno_id:',
            'bind' => array('solicitudTurno_id' => $solicitudTurno->getSolicitudturnosFechasturnos())));
        if (!$ultimoPeriodo) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> EL LINK HA CADUCADO, LA ASISTENCIA NO SE PUEDE CANCELAR PORQUE NO HAY UN PERÍODO ACTIVO <br></h3>");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 4) {
            $this->flash->error("<h3><i class='fa fa-warning'></i> LA ASISTENCIA YA SE ENCUENTRA CANCELADA</h3>");
            return $this->redireccionar('turnos/resultadoConfirmacion');
        }
        return $this->dispatcher->forward(array(
            "controller" => "turnos",
            "action" => "verTurno",
            "params" => array('solicitudTurno_id' => $this->request->get('id', 'trim'))
        ));

    }

    /**
     * public
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
     * public
     * Busca el turno solicitado y lo deshabilita, lo que conlleva:
     * - Liberar un turno: fechasTurnos_sinTurnos = 0 , fechasTurnos_cantidadAutorizados --
     * @return null
     */
    public function verTurnoAction()
    {
        $this->tag->setTitle('Consulta de Turno');

        if (!$this->request->isPost()) {
            //Proviene de cancelarEmail
            $this->view->titulo = "Confirmar/Cancelar Asistencia";
            $idSolicitud = $this->dispatcher->getParam("solicitudTurno_id");
            $id = base64_decode($idSolicitud);
            $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_id=:id:',
                'bind' => array('id' => $id)));
            if (!$solicitudTurno) {
                $this->flash->error('SU SOLICITUD DE TURNO NO SE ENCUENTRA CARGADA EN NUESTRA BASE DE DATOS');
                return $this->redireccionar('turnos/buscarTurno');
            }
        } else {
            $this->view->titulo = "Consulta de turno";
            //Validacion
            if (!$this->request->hasPost('legajo') || $this->request->getPost('legajo', 'int') == null) {
                $this->flash->error('INGRESE EL LEGAJO');
            }

            if (!$this->request->hasPost('codigo') || $this->request->getPost('codigo', 'alphanum') == null) {
                $this->flash->error('INGRESE EL CODIGO');
            }
            //Buscar Solicitud
            $legajo = $this->request->getPost('legajo', 'int');
            $codigo = $this->request->getPost('codigo', 'alphanum');
            $solicitudTurno = Solicitudturno::findFirst(array('solicitudTurno_legajo=:legajo: AND
         solicitudTurno_codigo=:codigo: ',
                'bind' => array('legajo' => $legajo, 'codigo' => $codigo)));
            if (!$solicitudTurno) {
                $this->flash->error('NO SE HA ENCONTRADO EL TURNO ASOCIADO CON LOS DATOS INGRESADO');
                return $this->redireccionar('turnos/buscarTurno');
            }
        }

        if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() != 1 && $solicitudTurno->getSolicitudturnoEstadoasistenciaid() != 2) {
            $this->flash->error('SR/A AFILIADO/A, USTED NO TIENE ASIGNADO UN TURNO. <br> LOS TURNOS QUE NO FUERON CANCELADOS O AQUELLOS CUYO PLAZO DE CONFIRMACIÓN HAN FINALIZADO SERÁN DESHABILITADOS.');
            return $this->redireccionar('turnos/buscarTurno');
        }
        //AUTORIZADO
        if ($solicitudTurno->getSolicitudturnoEstado() == "AUTORIZADO") {
            $dentroPlazoValido = true;
            if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 1) {
                $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoOnline($solicitudTurno->getSolicitudturnoFechapedido());
                $fechaLimiteConfirmacion = strtotime('+4 day', strtotime($solicitudTurno->getSolicitudturnoFechapedido()));
                $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
                $fechaVencimiento = TipoFecha::fechaEnLetras($fechaLimiteConfirmacion);

            } else {
                if ($solicitudTurno->getSolicitudturnoTipoturnoid() == 2) {
                    $dentroPlazoValido = Fechasturnos::verificarConfirmacionDentroPlazoTerminal($solicitudTurno->getSolicitudturnoFechapedido());
                    $fechaLimiteConfirmacion = strtotime('+3 day', strtotime($solicitudTurno->getSolicitudturnoFechapedido()));
                    $fechaLimiteConfirmacion = date('Y-m-d', $fechaLimiteConfirmacion);
                    $fechaVencimiento = TipoFecha::fechaEnLetras($fechaLimiteConfirmacion);

                }
            }
            if (!$dentroPlazoValido) {
                $this->flash->error('<h3>El plazo para confirmar/cancelar el turno ha finalizado el día ' . $fechaVencimiento . '. Por favor, vuelva a solicitar un turno nuevamente.</h3>');
                return $this->redireccionar('turnos/buscarTurno');
            }
            $this->view->solicitud_id = base64_encode($solicitudTurno->getSolicitudturnoId());
            //Pendiente de confirmacion
            if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 1) {
                $this->flash->notice('<h3>Su asistencia se encuentra <strong>PENDIENTE</strong> </h3>
                    <h4>Por favor, confirme/cancele su asistencia. Recuerde que tiene tiempo hasta el ' . $fechaVencimiento . ' de lo contrario el sistema acumulará una sanción.</h4>');
                $this->view->pendiente = true;
                $this->view->legajo = $solicitudTurno->getSolicitudturnoLegajo();
                $this->view->apeNom = $solicitudTurno->getSolicitudturnoNomape();
            }
            //Confirmado
            if ($solicitudTurno->getSolicitudturnoEstadoasistenciaid() == 2) {
                $this->flash->notice('<h3>Su asistencia se encuentra <strong>CONFIRMADA</strong> </h3>
                    <h4>Si desea cancelarla, recuerde que tiene tiempo hasta el ' . $fechaVencimiento . '.</h4>');
                $this->view->confirmado = true;
                $this->view->legajo = $solicitudTurno->getSolicitudturnoLegajo();
                $this->view->apeNom = $solicitudTurno->getSolicitudturnoNomape();
                $this->view->codigo = $solicitudTurno->getSolicitudturnoCodigo();

            }
        }//SI NO ES AUTORIZADO NO TIENE CODIGO.
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
     * ELIMINAR
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
     * ELIMINAR?
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
     * public
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


    public function solicitudesPorPeriodoAction()
    {
        $this->importarDataTables();
        $idPeriodo = $this->request->get('idP');
        $periodo = Fechasturnos::findFirstByFechasTurnos_id($idPeriodo);

        if ($periodo) {
            $this->view->ffInicioSol = date('d/m/Y', strtotime($periodo->fechasTurnos_inicioSolicitud));
            $this->view->ffFinSol = date('d/m/Y', strtotime($periodo->fechasTurnos_finSolicitud));
            $this->view->ffInicioAtencion = date('d/m/Y', strtotime($periodo->fechasTurnos_diaAtencion));
            $this->view->ffFinAtencion = date('d/m/Y', strtotime($periodo->fechasTurnos_diaAtencionFinal));
            $this->view->idP = $idPeriodo;
        }
    }

    public function solicitudesPorPeriodoAjaxAction()
    {
        $this->view->disable();

        $id = $this->request->get('id');

        $retorno = array();
        $datos = array();

        $solicitudes = Solicitudturno::find(array('solicitudTurnos_fechasTurnos = :fechasTurnos_id:',
            'bind' => array('fechasTurnos_id' => $id),
            'order' => 'solicitudTurno_id ASC'));
        foreach ($solicitudes as $unaSolicitud) {
            $item = array();

            $item[] = '<h4><ins>' . $unaSolicitud->getSolicitudturnoLegajo() . '</ins></h4>  ' . $unaSolicitud->getSolicitudturnoNomape();//0 Afiliado

            if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                $email = '';
            else
                $email = "" . $unaSolicitud->getSolicitudturnoEmail();

            $item[] = "<i class='fa fa-envelope-o'></i> " . $email . " <br/> <i class='fa fa-phone-square'></i> " . $unaSolicitud->getSolicitudturnoNumtelefono(); //1 Email/Telefono


            $item[] = $unaSolicitud->getSolicitudturnoNickusuario();// 2 Usuario
            $item[] = $unaSolicitud->getSolicitudturnoEstado();// 3 Estado turno
            $item[] = $unaSolicitud->getSolicitudturnoObservaciones(); // 4 Observaciones
            $item[] = $unaSolicitud->getSolicitudturnoCodigo();//5 Codigo

            switch ($unaSolicitud->getSolicitudturnoEstadoasistenciaid()) {
                case 1:
                    $estadoAsistencia = 'EN ESPERA';
                    break;
                case 2:
                    $estadoAsistencia = "CONFIRMADO";
                    break;
                case 3:
                    $estadoAsistencia = "PLAZO VENCIDO";
                    break;
                case 4:
                    $estadoAsistencia = "CANCELADO";
                    break;
                default :
                    $estadoAsistencia = ' ';
                    break;
            }

            $item[] = $estadoAsistencia; // 6 Estado Asistencia
            $item[] = Tipoturno::buscarTipoPorId($unaSolicitud->getSolicitudturnoTipoturnoid());// 7 tipo solicitud

            $datos[] = $item;
        }

        $retorno['data'] = $datos;
        echo json_encode($retorno);
        return;
    }

    public function solicitudesCanceladasPorPeriodoAction()
    {
        $this->importarDataTables();
        $idPeriodo = $this->request->get('idP');
        $periodo = Fechasturnos::findFirstByFechasTurnos_id($idPeriodo);

        if ($periodo) {
            $this->view->ffInicioSol = date('d/m/Y', strtotime($periodo->fechasTurnos_inicioSolicitud));
            $this->view->ffFinSol = date('d/m/Y', strtotime($periodo->fechasTurnos_finSolicitud));
            $this->view->ffInicioAtencion = date('d/m/Y', strtotime($periodo->fechasTurnos_diaAtencion));
            $this->view->ffFinAtencion = date('d/m/Y', strtotime($periodo->fechasTurnos_diaAtencionFinal));
            $this->view->idP = $idPeriodo;
        }
    }

    public function solicitudesCanceladasPorPeriodoAjaxAction()
    {
        $this->view->disable();

        $id = $this->request->get('id');

        $retorno = array();
        $datos = array();

        $solicitudes = Solicitudturno::find(
            array('solicitudTurnos_fechasTurnos = :fechasTurnos_id: and solicitudTurno_estadoAsistenciaId = 4',
                'bind' => array('fechasTurnos_id' => $id),
                'order' => 'solicitudTurno_id ASC'));

        foreach ($solicitudes as $unaSolicitud) {
            $item = array();

            $item[] = '<h4><ins>' . $unaSolicitud->getSolicitudturnoLegajo() . '</ins></h4>  ' . $unaSolicitud->getSolicitudturnoNomape();//0 Afiliado

            if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                $email = '';
            else
                $email = "" . $unaSolicitud->getSolicitudturnoEmail();

            $item[] = "<i class='fa fa-envelope-o'></i> " . $email . "<br/><i class='fa fa-phone-square'></i> " . $unaSolicitud->getSolicitudturnoNumtelefono();//1 Email/Telefono
            $item[] = $unaSolicitud->getSolicitudturnoNickusuario();//2 nick Usuario
            $item[] = $unaSolicitud->getSolicitudturnoEstado();//3 Estado solicitud
            $item[] = $unaSolicitud->getSolicitudturnoObservaciones(); //4 Observaciones

            $datos[] = $item;
        }

        $retorno['data'] = $datos;
        echo json_encode($retorno);
        return;
    }
}



