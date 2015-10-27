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
        $this->menuPpal();
        $turnosOnlineForm = new TurnosOnlineForm();

        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if ($turnosOnlineForm->isValid($data) != false) //aqui es donde valida los datos ingresados
            {
                $razonNoDisponible = $this->verificarDisponibilidad();

                if ($razonNoDisponible == "") {
                    $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                    $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                    $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                    $documento = $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string'));
                    $numTelefono = $this->request->getPost('solicitudTurno_numTelefono', 'int');
                    $email = $this->request->getPost('solicitudTurno_email', array('email', 'trim'));

                    $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);

                    if ($nombreCompleto != "") {
                        if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto)) {
                            $seGuardo = Solicitudturno::accionAgregarUnaSolicitudOnline($legajo, $nombreCompleto, $documento, $email, $numTelefono);

                            if ($seGuardo)//la solicitud se ingreso con exito.
                            {
                                $this->flash->message('exito', 'LA SOLICITUD FUE INGRESADA CORRECTAMENTE');
                                $turnosOnlineForm->clear();
                                $this->redireccionar('turnos/turnoSolicitadoExitoso');
                            } else
                                $this->flash->message('problema', 'OCURRIO UN PROBLEMA, POR FAVOR VUELVA A INTENTARLO EN UNOS MINUTOS.');
                        } else
                            $this->flash->message('problema', 'SUS DATOS YA FUERON INGRESADOS, NO PUEDE OBTENER MÁS DE UN TURNO POR PERÍODO');
                    } else
                        $this->flash->message('problema', 'USTED NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.');
                } else
                    $this->flash->message('problema', $razonNoDisponible);
            }
        }

        $this->view->formulario = $turnosOnlineForm;
    }

    public function solicitudManualAction()
    {
        $turnoManualForm = new TurnoManualForm();

        if ($this->request->isPost()) {
            if ($turnoManualForm->isValid($this->request->getPost()) != false) //aqui es donde valida los datos ingresados
            {
                $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                $documento = $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string'));
                $numTelefono = $this->request->getPost('solicitudTurno_numTelefono', 'int');
                $estado = $this->request->getPost('solicitudTurno_estado');
                $miSesion = $this->session->get('auth');
                $nickActual = $miSesion['usuario_nick'];

                $razonNoDisponible = $this->verificarDisponibilidad();

                if ($razonNoDisponible == "") {
                    $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);

                    if ($nombreCompleto != "") {
                        if (!$this->tieneTurnoSolicitado($legajo, $nombreCompleto)) {
                            $seGuardo = Solicitudturno::accionAgregarUnaSolicitudManual($legajo, $nombreCompleto, $documento, $numTelefono, $estado, $nickActual);

                            if ($seGuardo)//la solicitud se ingreso con exito.
                            {
                                if ($estado == 'AUTORIZADO')
                                    Fechasturnos::incrementarCantAutorizados();

                                $turnoManualForm->clear();
                                $this->flash->message('exito', 'LA SOLICITUD DE TURNO FUE INGRESADA CON EXITO.');
                            } else
                                $this->flash->message('problema', 'OCURRIO UN ERROR, INTENTE MAS TARDE.');
                        } else
                            $this->flash->message('problema', 'EL AFILIADO YA SOLICITO UN TURNO, POR LO CUAL NO SE PUEDE INGRESAR ESTA SOLICITUD.');
                    } else
                        $this->flash->message('problema', 'EL AFILIADO NO ESTA REGISTRADO EN EL SISTEMA O ALGUNO DE LOS DATOS INGRESADOS SON INCORRECTOS.');
                } else
                    $this->flash->message('problema', $razonNoDisponible);
            }
        }
        $this->view->formulario = $turnoManualForm;
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

            if ($result->numRows() != 0) {
                $afiliados = $result->fetch();
                return $afiliados["afiliado_apenom"];
            }
        } catch (Phalcon\Db\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
        }
        return "";
    }

    /* public function guardarSolicitudTurnoAction()
     {
     }*/

    /**
     * Se encarga de realizar 2 verificaciones:
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
                    return "LO SENTIMOS, NO HAY CUPOS DISPONIBLES.";
                else
                    return "";
            else
                return "NO ES POSIBLE SOLICITAR TURNOS EN LA FECHA ACTUAL. VERIFIQUE LAS FECHAS EN NUESTRA PAGINA WEB.";
        }
        return "NO HAY FECHAS DISPONIBLES PARA SOLICITAR TURNOS. VERIFIQUE LOS PERIODOS DE SOLICITUD EN LA PAGINA WEB.";

    }

    /**
     * Verifica con los datos del afiliado si ya solicito un turno en este periodo.
     * MJE ERROR: SUS DATOS YA FUERON INGRESADO, NO PUEDE SACAR MÁS DE UN TURNO POR PERÍODO
     * @return boolean devuelve si encontro o no.
     */
    private function tieneTurnoSolicitado($legajo, $nomApe)
    {
        try {
            //$ultimo = (int)Fechasturnos::count() - 1;//Obtengo el ultimo indice
            $fechasTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo (campo nuevo).
            $consulta = "SELECT * FROM solicitudTurno AS ST WHERE ((DATE(ST.solicitudTurno_fechaPedido) BETWEEN :inicioSolicitud: AND :finSolicitud:) AND ((ST.solicitudTurno_legajo=:legajo:) OR (ST.solicitudTurno_nomApe LIKE  :nomApe:)))";

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
     * Muestra el formulario de periodos, lo valida y guarda en la base de datos.
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
                //PeriodoSolicitud = Fechasturnos.
                $fechasTurnos = new Fechasturnos();
                $fechasTurnos->assign(array(
                    'fechasTurnos_inicioSolicitud' => $this->request->getPost('periodoSolicitudDesde'),
                    'fechasTurnos_finSolicitud' => $this->request->getPost('periodoSolicitudHasta'),
                    'fechasTurnos_diaAtencion' => $this->request->getPost('periodoAtencionDesde'),
                    'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('cantidadTurnos', 'int'),
                    'fechasTurnos_cantidadAutorizados' => 0,
                    'fechasTurnos_cantidadDiasConfirmacion' => $this->request->getPost('cantidadDias', 'int'),
                    'fechasTurnos_activo' => 1,
                ));

                if ($fechasTurnos->save()) {
                    //Si ya habia un periodo, lo desactivamos.
                    if ($fechasTurnos->fechasTurnos_id > 1) {
                        $phql = "UPDATE Fechasturnos SET fechasTurnos_activo = :valor: WHERE fechasTurnos_id = :id:";
                        $this->modelsManager->executeQuery($phql, array(
                            'id' => $fechasTurnos->fechasTurnos_id - 1,
                            'valor' => 0
                        ));
                    }

                    $this->flash->message('exito', 'La configuración de los períodos se ha realizado satisfactoriamente.');
                    $periodoSolicitudForm->clear();
                }
                $this->flash->error($fechasTurnos->getMessages());
            }
        }
    }

    /**
     * Muestra una grilla paginada con los datos de los afiliados que solicitaron turnos.
     *
     *
     */
    public function turnosSolicitadosAction()
    {

       $solicitudTurnos = $this->modelsManager->createBuilder()
            ->from('Solicitudturno');
        $paginator = new PaginacionBuilder
        (
            array(
                "builder" => $solicitudTurnos,
                //limite por página
                "limit" => 15,
                //variable get page convertida en un integer
                "page" => $this->request->getQuery('page', 'int')
            )
        );
        $this->view->page = $paginator->getPaginate();

        $this->view->autorizadosEnviados = $this->cantRtasAutorizadasEnviadas();
        $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo .
        $this->view->cantidadDeTurnos   = $fechaTurnos->fechasTurnos_cantidadDeTurnos;
        //$this->view->formularioSimple = new EditarSolicitudTurnoForm();
        //$this->view->formulario = new EditarSolicitudTurnoForm(null,array('revision'=>'true'));
    }
    public function editAction($idSolicitud)
    {
        echo "ENTRAAAA";
        //deshabilitamos la vista para peticiones ajax
        $this->view->disable();
    }
    public function turnosRespondidosAction()
    {
        $paginator = new PaginatorArray
        (
            array(
                "data" => Solicitudturno::accionVerSolicitudesConRespuestaEnviada(),
                //limite por página
                "limit" => 15,
                //variable get page convertida en un integer
                "page" => $this->request->getQuery('page', 'int')
            )
        );
        $this->view->page = $paginator->getPaginate();
    }

    public function cantRtasAutorizadasEnviadas()
    {
        try {
            $cant = 0;
            $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo .
            $fI = $fechaTurnos->fechasTurnos_inicioSolicitud;
            $fF = $fechaTurnos->fechasTurnos_finSolicitud;

            $sql = "SELECT count(*) as cantidad FROM solicitudTurno WHERE (DATE(solicitudTurno_fechaPedido) BETWEEN '$fI' and '$fF'
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

    public function editarSolicitudAction($idSolicitud)
    {

        //falta preguntar por el rol de usuario...
        // (EL ROL DE SUPERVISOR SOLAMENTE PUEDE MODIFCAR LOS TURNOS??? O EL ROL BASICO DE EMPLEADOS DE IMPS TAMBIEN ???)


        //LO QUE ESTA HECHO ES PARA LOS ROLES DE ADMIN Y SUPERVISOR.

        $unaSolicitud = Solicitudturno::findFirstBySolicitudTurno_id($idSolicitud);

        if ($unaSolicitud) {
            $soloLectura = ''; //coomo puedo hacer para que esta variable me permita ponerle al atributo readonly????

            $estado = $unaSolicitud->solicitudTurno_estado;
            $montoMax = $unaSolicitud->solicitudTurno_montoMax;
            $montoPos = $unaSolicitud->solicitudTurno_montoPosible;
            $cantCuotas = $unaSolicitud->solicitudTurno_cantCuotas;
            $valorCuota = $unaSolicitud->solicitudTurno_valorCuota;
            $obs = $unaSolicitud->solicitudTurno_observaciones;

            $nickAnterior = $unaSolicitud->solicitudTurno_nickUsuario;// usuario viejo
            $miSesion = $this->session->get('auth');
            $nickActual = $miSesion['usuario_nick'];

            $cantAutorizadosEnviados = $this->cantRtasAutorizadasEnviadas();
            $fechaTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo .
            $cantTurnos = $fechaTurnos->fechasTurnos_cantidadDeTurnos;
            $todosAutEnviados = false;

            $listaUno = array('pendiente' => 'pendiente');
            $listaDos = array('pendiente' => 'pendiente', 'revision' => 'revision');
            $listaTres = array("pendiente" => "pendiente", "revision" => "revision", "autorizado" => "autorizado", "denegado" => "denegado", "denegado por falta de turnos" => "denegado por falta de turnos");
            $listaCuatro = array('denegado por falta de turnos' => 'denegado por falta de turnos');

            if (($cantAutorizadosEnviados > 0) && ($cantAutorizadosEnviados == $cantTurnos))
                $todosAutEnviados = true;

            if ($todosAutEnviados) {
                $this->view->lista = $listaCuatro;
                // $this->view->soloLectura; //no se pueden editar los montos, cantidad, valor,observacion
            } else {
                if ($estado == 'pendiente') {
                    $this->view->lista = $listaDos;
                    $this->view->soloLectura = 'readonly';
                } else {
                    if ($estado == 'revision' or $estado == 'autorizado' or $estado == 'denegado' or $estado == 'denegado por falta de turnos') {
                        $this->view->lista = $listaTres;
                        $this->view->soloLectura = '';
                    } else {
                        if ($estado != 'pendiente' or $estado != 'revision' or $estado != 'autorizado' or $estado != 'denegado') {
                            $this->view->lista = $listaUno;
                            //  $this->view->soloLectura;
                        }
                    }
                }
            }

            $this->view->idSolicitud = $idSolicitud;
            $this->view->estado = $estado;
            $this->view->montoM = $montoMax;
            $this->view->montoP = $montoPos;
            $this->view->cantCuotas = $cantCuotas;
            $this->view->valorCuota = $valorCuota;
            $this->view->obs = $obs;
        }
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

    public function guardarDatosEdicionAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('idSolicitud');
            $estado = $this->request->getPost('estado');
            $montoP = $this->request->getPost('montoP');
            $montoM = $this->request->getPost('montoM');
            $cantCuotas = $this->request->getPost('cantCuotas');
            $valorCuota = $this->request->getPost('valorCuota');
            $obs = $this->request->getPost('obs');

            $unaSolicitud = Solicitudturno::findFirst(array("solicitudTurno_id=?1", "bind" => array(1 => $id)));

            if ($unaSolicitud) {
                $unaSolicitud->solicitudTurno_estado = $estado;
                $unaSolicitud->solicitudTurno_montoPosible = $montoP;
                $unaSolicitud->solicitudTurno_montoMax = $montoM;
                $unaSolicitud->solicitudTurno_cantCuotas = $cantCuotas;
                $unaSolicitud->solicitudTurno_valorCuota = $valorCuota;
                $unaSolicitud->solicitudTurno_observaciones = $obs;
                $unaSolicitud->solicitudTurno_fechaProcesamiento = date('Y-m-d');

                $miSesion = $this->session->get('auth');
                $unaSolicitud->solicitudTurno_nickUsuario = $miSesion['usuario_nick'];

                if ($unaSolicitud->save()) {
                    $this->flash->message('exito', "Los datos se guardaron correctamente!");
                    return $this->dispatcher->forward(array("action" => "vuelta"));
                } else {
                    $this->flash->message('problema', "Ocurrio un error, no se pudieron guardar los datos.");
                    return $this->dispatcher->forward(array("action" => "vuelta"));
                }
            } else {
                $this->flash->message('problema', "Los cambios a la solicitud no se pudieron guardar.");
                return $this->dispatcher->forward(array("action" => "vuelta"));
            }
        }
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
                "data" => Fechasturnos::find(),
                //limite por página
                "limit" => 6,
                //variable get page convertida en un integer
                "page" => $this->request->getQuery('page', 'int')
            )
        );

        //pasamos el objeto a la vista con el nombre de $page
        $this->view->tabla = $paginator->getPaginate();
    }

    public function enviarRespuestasAction()
    {
        $solicitudesAutorizadas = Solicitudturno::recuperaSolicitudesSegunEstado('AUTORIZADO');
        $solicitudesDenegadas = Solicitudturno::recuperaSolicitudesSegunEstado('DENEGADO');
        $solicitudesDenegadasFaltaTurnos = Solicitudturno::recuperaSolicitudesSegunEstado('denegado por falta de turnos');

        if (count($solicitudesAutorizadas) == 0 && count($solicitudesDenegadas) == 0 && count($solicitudesDenegadasFaltaTurnos) == 0) {
            $this->flash->message('problema', "No se pueden enviar respuestas, ya que solo hay solicitudes pendientes o en revisión.");
            $this->view->pick('turnos/vuelta');
        } else {
            $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
            $fechaAtencion = date('d-m-Y', strtotime($ultimoPeriodo->fechasTurnos_diaAtencion));

            $textoA = "En respuesta a su solicitud, le informamos que podrá dirigirse al Instituto Municipal de Previsión Social el dia " . $fechaAtencion . " para tramitar un préstamo personal.";
            $textoDxFdT = "En respuesta a su solicitud, le informamos que no es posible otorgarle un turno para tramitar un préstamo personal porque todos los turnos disponibles para este mes ya fueron dados.";
            $textoD = "En respuesta a su solicitud, le informamos que no es posible otorgarle un turno para tramitar un préstamo personal.";

            if (count($solicitudesAutorizadas) != 0)
                $this->envioRespuestas($solicitudesAutorizadas, $textoA, 'A');

            if (count($solicitudesDenegadas) != 0)
                $this->envioRespuestas($solicitudesDenegadas, $textoD, 'D');

            if (count($solicitudesDenegadasFaltaTurnos) != 0)
                $this->envioRespuestas($solicitudesDenegadasFaltaTurnos, $textoDxFdT, 'DFT');

            $this->flash->message('exito', "Las respuestas fueron enviadas a los afiliados.");
            $this->view->pick('turnos/vuelta');
        }
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

        $this->mailInformatica->addAddress($correo, $nomApe);
        $this->mailInformatica->Subject = "Respuesta por solicitud de un turno en IMPS.";

        $idCodif = base64_encode($idSol);

        $texto = "Estimado/a  " . $nomApe . ":<br/> <br/>" . $mensaje . '<br/>';
        $textoFinal = "Para confirmar que recibio este mensaje, por favor"
            . " <a href='http://localhost/impsweb/turnos/confirmaEmail?id=" . $idCodif . "' target='_blank'>haga click aqui.</a>"
            . "<br/><br/> Saluda atte.,<br/> Instituto Municipal de Previsión Social <br/> Fotheringham 277 - Neuquén Capital. <br/> Teléfono:(299)- 4433798";

        if ($tipoEstado == 'A') {
            $cad1 = " El monto máximo que se le puede prestar es $" . $montoM . " y el monto posible que se le puede otorgar es $" . $montoP . ".";
            $cadena = $cad1 . " La cantidad de cuotas es " . $cantCuotas . " y el valor de cada una de ellas es de $" . $valorCuota . '.<br/>';

            if ($obs != '-' && $obs != '')
                $cadena .= "Nota: " . $obs . "<br/>";

            $cadena .= "Recuerde que usted tiene " . $diasConfirmacion . " dias para confirmar el mensaje, de lo contrario el turno sera cancelado.<br/>";

            $this->mailInformatica->Body = $texto . $cadena . $textoFinal;
        } else {
            if ($obs != '-' && $obs != '')
                $texto .= "Nota: " . $obs . "<br/>";

            $this->mailInformatica->Body = $texto . $textoFinal;
        }

        $send = $this->mailInformatica->send();
    }

    public function confirmaEmailAction()
    {

    }
}

