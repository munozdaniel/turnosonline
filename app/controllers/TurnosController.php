<?php
//obtenemos el adaptador que crea la paginación en Phalcon
use \Phalcon\Paginator\Adapter\Model as Paginacion;
use \Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class TurnosController extends ControllerBase
{
    /**
     * Inicializa el controlador turnos con el template admin, ya que la mayoria de  las acciones
     * se executan estando logueado. Para aquellas paginas que no necesitan login se setean los template
     * manualmente para cada accion.
     */
    public function initialize()
    {
        $this->tag->setTitle('Turnos Online');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

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
            if ($turnosOnlineForm->isValid($data) != false) {
                $razonNoDisponible = $this->verificarDisponibilidad();
                if ($razonNoDisponible == "") {

                    $solicitudTurno = new Solicitudturno();
                    //Los datos que estan comentados se setean en el futuro.
                    $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                    $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                    $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                    $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);
                    if ($nombreCompleto != "") {
                        $email = $this->request->getPost('solicitudTurno_email', array('email', 'trim'));
                        if (!$this->tieneTurnoSolicitado($legajo, $email)) {
                            $solicitudTurno->assign(array(
                                'solicitudTurno_legajo' => $legajo,
                                'solicitudTurno_nomApe' => $nombreCompleto,
                                'solicitudTurno_documento' => $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string')),
                                'solicitudTurno_email' => $email,
                                'solicitudTurno_numTelefono' => $this->request->getPost('solicitudTurno_numTelefono', 'int'),
                                'solicitudTurno_fechaPedido' => date('Y-m-d'),
                                'solicitudTurno_estado' => "PENDIENTE",
                                'solicitudTurno_nickUsuario' => "-",
                                //'solicitudTurno_fechaProcesamiento'       => $this->request->getPost('cantidadTurnos','int'),
                                'solicitudTurno_respuestaEnviada' => "NO",
                                'solicitudTurno_respuestaChequeada' => 0,
                                //'solicitudTurno_fechaRespuestaEnviada'    => 0,
                                'solicitudTurno_montoMax' => 0,
                                'solicitudTurno_montoPosible' => 0,
                                'solicitudTurno_cantCuotas' => 0,
                                'solicitudTurno_valorCuota' => 0,
                                'solicitudTurno_observaciones' => "-",
                                'solicitudTurno_manual' => 0,
                            ));
                            if ($solicitudTurno->save()) {
                                $this->flash->message('exito', 'La configuración de los períodos se ha realizado satisfactoriamente.');
                                $turnosOnlineForm->clear();
                                $this->redireccionar('turnos/turnoSolicitadoExitoso');
                            }
                        } else
                            $this->flash->message('problema', 'SUS DATOS YA FUERON INGRESADO, NO PUEDE SACAR MÁS DE UN TURNO POR PERÍODO');
                    } else
                        $this->flash->message('problema', 'NO SE ENCUENTRA REGISTRADO EN EL SISTEMA, PARA MAS INFORMACIÓN DIRÍJASE A NUESTRAS OFICINAS.');
                } else
                    $this->flash->message('problema', $razonNoDisponible);


            }
        }
        $this->view->formulario = $turnosOnlineForm;

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
            $sql = "SELECT AF.afiliado_legajo, AF.afiliado_apenom FROM siprea2.afiliados AS AF WHERE (AF.afiliado_apenom LIKE '%" . $nombreCompleto . "%') AND (AF.afiliado_legajo LIKE '%" . $legajo . "%');";
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
    public function guardarSolicitudTurnoAction()
    {


    }
    /**
     * Se encarga de realizar 2 verificaciones:
     * 1. que la fecha de hoy se encuentra entre el periodo ingresado por los supervisores.
     * INICIO <= ACTUAL <= FINAL.
     * 2. Que existan cupos disponibles.
     * @return string muestra un mensaje si hubo problemas
     */
    private function verificarDisponibilidad()
    {
        if(Fechasturnos::count()!=0){
            $ultimo = (int)Fechasturnos::count() - 1;//Obtengo el ultimo indice
            $fechasTurnos = Fechasturnos::find();//Obtengo todos las instancias de Fechasturnos.
            if ($fechasTurnos[$ultimo]->fechasTurnos_inicioSolicitud <= date('Y-m-d')
                && date('Y-m-d')<=$fechasTurnos[$ultimo]->fechasTurnos_finSolicitud
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
    private function tieneTurnoSolicitado($legajo, $email)
    {
        try {
            //$ultimo = (int)Fechasturnos::count() - 1;//Obtengo el ultimo indice
            $fechasTurnos = Fechasturnos::findFirstByFechasTurnos_activo(1);//Obtengo el periodo activo (campo nuevo).
            $consulta = "SELECT * FROM solicitudTurno AS ST WHERE ((DATE(ST.solicitudTurno_fechaPedido) BETWEEN :inicioSolicitud: AND :finSolicitud:) AND (ST.solicitudTurno_legajo=:legajo:) AND (ST.solicitudTurno_email LIKE  :email:))";

            $solicitudTurno = $this->modelsManager->executeQuery($consulta,
                array(
                    'inicioSolicitud' => $fechasTurnos->fechasTurnos_inicioSolicitud,
                    'finSolicitud' => $fechasTurnos->fechasTurnos_finSolicitud,
                    'legajo' => $legajo,
                    'email' => $email));
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
     * Recupera los datos del formulario TurnosOnlineForm y controla que exista en la bd Siprea, en caso
     * afirmativo se inserta en la bd impsorg_web, en la tabla SolicitudTurno.
     */
    public function turnoSolicitadoAction()
    {
        echo "<h1>TURNO SOLICITADO!</h1>";

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
                    if($fechasTurnos->fechasTurnos_id>1){
                        $phql = "UPDATE Fechasturnos SET fechasTurnos_activo = :valor: WHERE fechasTurnos_id = :id:";
                        $this->modelsManager->executeQuery($phql, array(
                            'id' => $fechasTurnos->fechasTurnos_id-1,
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

    public function turnosSolicitadosAction()
    {
        $paginator = new PaginatorArray
        (
            array(
                "data" => Solicitudturno::accionVerSolicitudesOnline(),
                //limite por página
                "limit"=> 10,
                //variable get page convertida en un integer
                "page" => $this->request->getQuery('page', 'int')
            )
        );

        $this->view->page = $paginator->getPaginate();
    }

    public function editarSolicitudAction()
    {
        if ($this->request->isPost())
        {
            $id = $this->request->getPost('idSolicitud');
            $this->view->idSolicitud= $id;
        }
    }

   /* public function editarSolicitud2Action($id)
    {
        //aqui deberia buscar la solicitud y todos los datos que esta posea, luego mandarlos a la vista para que se pueden editar
        //ademas aca ver como podria controlar lo de los distintos estados y de si puede o no editar un campo, por ejemplo cant cuotas,
        //valor cuotas, montos.
    }*/


    public function guardarDatosEdicionAction()
    {
        if ($this->request->isPost())
        {
            $id = $this->request->getPost('idSolicitud');
            $estado = $this->request->getPost('estado');
            $montoP = $this->request->getPost('montoP');
            $montoM = $this->request->getPost('montoM');
            $cantCuotas = $this->request->getPost('cantCuotas');
            $valorCuota = $this->request->getPost('valorCuota');
            $obs = $this->request->getPost('obs');

            $unaSolicitud = Solicitudturno::findFirst(array("solicitudTurno_id=?1","bind"=>array(1=>$id)));

            if($unaSolicitud)
            {
                $unaSolicitud->solicitudTurno_estado= $estado;
                $unaSolicitud->solicitudTurno_montoPosible=$montoP;
                $unaSolicitud->solicitudTurno_montoMax=$montoM;
                $unaSolicitud->solicitudTurno_cantCuotas=$cantCuotas;
                $unaSolicitud->solicitudTurno_valorCuota=$valorCuota;
                $unaSolicitud->solicitudTurno_observaciones=$obs;
                $unaSolicitud->solicitudTurno_fechaProcesamiento=date('Y-m-d');

                $miSesion = $this->session->get('auth');
                $unaSolicitud->solicitudTurno_nickUsuario= $miSesion['usuario_nick'];

                if ($unaSolicitud->save())
                {
                    $this->flash->success("Los datos de guardaron correctamente!");
                    return $this->dispatcher->forward(array("action" => "vuelta"));
                }
                else
                {
                    $this->flash->error("Ocurrio un error, no se pudieron guardar los datos.");
                    return $this->dispatcher->forward(array("action" => "vuelta"));
                }
            }
            else
            {
                $this->flash->error("Los cambios a la solicitud no se pudieron guardar.");
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
        //if ($this->request->isPost()) {
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
       // }
    }


}

