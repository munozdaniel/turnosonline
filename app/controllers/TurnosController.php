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
     * Formulario para guardar un nuevo periodo
     */
    public function periodoSolicitudAction()
    {
        $this->tag->setTitle('Periodo de Turnos');
        $this->view->formulario = new PeriodoSolicitudForm();
    }

    /**
     * Guarda un nuevo periodo. Deshabilita el periodo anterior.
     * Rol: Supervisor/Administrador
     */
    public function guardarPeriodoSolicitudAction()
    {
        $this->tag->setTitle('Periodo de Turnos');

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

                if ($fechaVencimiento < $periodoDiaAtencion)
                {
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
                    $this->db->commit();
                    $this->flash->message('exito', 'La configuración de las fechas se ha realizado satisfactoriamente.');
                    $periodoSolicitudForm->clear();
                    return $this->redireccionar('administrar/index');
                }
                else
                    $this->flash->message('problema', "El <ins>periodo para atención de turnos</ins> debe
                                                comenzar por lo menos despues de una semana de finalizado el periodo de solicitud de turnos.<br/>
                                                Por favor modifique las fechas de atención.");
            }
        }
    }

    /**
     * Encargado de dehabilitar un periodo. Por lo general se deshabilitan automaticamente, pero tambien se
     * podrá realizar manualmente.
     */
    public function deshabilitarAction($idPeriodo)
    {
        $this->tag->setTitle('Deshabilitar Periodo');
        $periodo = Fechasturnos::findFirstByFechasTurnos_id($idPeriodo);
        $periodo->fechasTurnos_activo = 0;
        if (!$periodo->update()) {
            $this->flash->error("NO SE HA PODIDO DESHABILITAR EL PERÍODO, INFORMAR AL SOPORTE TÉCNICO.");
        }
        $this->redireccionar('turnos/verPeriodos');
    }

    /**
     * Muestra una grilla paginada con los datos de los afiliados que solicitaron turnos.
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
     * @return int
     */
    private function cantRtasAutorizadasEnviadas()
    {
        $cant = 0;
        try {
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
    /**
     * @desc - permitimos editar la informacion del prestamo. AJAX
     * @return json
     */
    public function editarSolcitudAjaxAction()
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
                    $item[] = base64_encode($unaSolicitud->getSolicitudturnoId()); //se codifico para que funcione el aceptar/cancelar asistencia
                    //1 Tipo de Turno: para pintar la fila de rojo
                    $item[] = $unaSolicitud->getSolicitudturnoEstadoasistenciaid();
                    //2 Afiliado
                    $item[] = '<h4><ins>' . $unaSolicitud->getSolicitudturnoLegajo() . ' </ins></h4>' . $unaSolicitud->getSolicitudturnoNomape();
                    //3 Email/Telefono
                    if ($unaSolicitud->getSolicitudturnoEmail() == NULL || trim($unaSolicitud->getSolicitudturnoEmail()) == "")
                        $email = '';
                    else
                        $email = "" . $unaSolicitud->getSolicitudturnoEmail();
                    $item[] = "<i class='fa fa-envelope-o'></i> " . $email . " <br> <i class='fa fa-phone-square'></i> " . $unaSolicitud->getSolicitudturnoNumtelefono();
                    //4 FechaRespuestaEnviada
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

                    //5 Usuario
                    $item[] = $unaSolicitud->getSolicitudturnoNickusuario();
                    //6 Estado Deuda: Autorizado, denegado, denegado por falta de turno
                    $item[] = $unaSolicitud->getSolicitudturnoEstado();
                    //7 Observaciones
                    $item[] = $unaSolicitud->getSolicitudturnoObservaciones();
                    //8 Codigo
                    $item[] = $unaSolicitud->getSolicitudturnoCodigo();
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
     * Se usa??
     */
    public function vueltaAction()
    {
        //no hace nada, esta solo para que vaya a la vista.
    }
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
            $retorno['mensaje'] = "No es posible enviar las respuestas, porque no hay solicitudes que se hayan autorizado o denegado.";
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
        $template = str_replace('%linkConfirmar%', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../solicitudTurno/confirmaEmail/?id=' . $idCodificado, $template);
        $template = str_replace('%linkCancelar%', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/../solicitudTurno/cancelarEmail/?id=' . $idCodificado, $template);
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

        $periodoSolicitudForm->clear();
        $this->flash->message('exito', "ACTUALIZACIÓN EXITOSA");
        $this->db->commit();
        return $this->redireccionar('turnos/verPeriodos');
    }

    /**
     * Recupera todas las solicitudes  que hubo por cada periodo
     */
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

    /**
     * Completa la tabla por ajax de todas las solicitudes de un periodo.
     */
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

    /**
     * Muestra todas las solicitudes canceladas de un periodo.
     */
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



