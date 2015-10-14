<?php

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
    /*================================ index =======================================*/
    /**
     * Muestra el formulario para solicitar turno.
     */
    public function indexAction()
    {
        $this->menuPpal();

        $turnosOnlineForm = new TurnosOnlineForm();


        if ($this->request->isPost()) {
            $data = $this->request->getPost();

            if ($turnosOnlineForm->isValid($data) != false) {

                //PeriodoSolicitud = Fechasturnos.
                $solicitudTurno = new Solicitudturno();
                //Los datos que estan comentados se setean en el futuro.
                $legajo = $this->request->getPost('solicitudTurno_legajo', array('alphanum', 'trim'));
                $nombre = $this->request->getPost('solicitudTurno_nom', array('striptags', 'string', 'upper'));
                $apellido = $this->request->getPost('solicitudTurno_ape', array('striptags', 'string', 'upper'));
                $nombreCompleto = $this->comprobarDatosEnSiprea($legajo, $apellido . " " . $nombre);
                if ( $nombreCompleto != "") {

                    $solicitudTurno->assign(array(
                        'solicitudTurno_legajo'                     => $legajo,
                        'solicitudTurno_nomApe'                     => $nombreCompleto,
                        'solicitudTurno_documento'                  => $this->request->getPost('solicitudTurno_documento', array('alphanum', 'trim', 'string')),
                        'solicitudTurno_email'                      => $this->request->getPost('solicitudTurno_email', array('email', 'trim')),
                        'solicitudTurno_numTelefono'                => $this->request->getPost('solicitudTurno_numTelefono', 'int'),
                        'solicitudTurno_fechaPedido'                => date('y-m-d'),
                        'solicitudTurno_estado'                     => "PENDIENTE",
                        'solicitudTurno_nickUsuario'                => "-",
                        //'solicitudTurno_fechaProcesamiento'       => $this->request->getPost('cantidadTurnos','int'),
                        'solicitudTurno_respuestaEnviada'           => "NO",
                        'solicitudTurno_respuestaChequeada'         => 0,
                        //'solicitudTurno_fechaRespuestaEnviada'    => 0,
                        'solicitudTurno_montoMax'                 => 0,
                        'solicitudTurno_montoPosible'             => 0,
                        'solicitudTurno_cantCuotas'               => 0,
                        'solicitudTurno_valorCuota'               => 0,
                        'solicitudTurno_observaciones'            => "-",
                        'solicitudTurno_manual'                   => 0,
                    ));
                    if ($solicitudTurno->save()) {
                        $this->flash->message('exito','La configuración de los períodos se ha realizado satisfactoriamente.');
                        $turnosOnlineForm->clear();
                        $this->redireccionar('turnos/turnoSolicitado');
                    }
                }
                $this->flash->message('problema', 'NO SE ENCUENTRA EN LA BASE DE DATOS DE SIPREA.');
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
            echo "$legajo - $nombreCompleto ";
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
    private function verificarDisponibilidad(){
        $fechasTurnos = new Fechasturnos();

    }
    /**
     * Recupera los datos del formulario TurnosOnlineForm y controla que exista en la bd Siprea, en caso
     * afirmativo se inserta en la bd impsorg_web, en la tabla SolicitudTurno.
     */
    public function turnoSolicitadoAction()
    {
        echo "<h1>TURNO SOLICITADO!</h1>";

    }

    /*================================ periodoSolicitud =======================================*/
    public function periodoSolicitudAction()
    {
        $this->view->formulario = new PeriodoSolicitudForm();
    }

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
                    'fechasTurnos_inicioAtencion' => $this->request->getPost('periodoAtencionDesde'),
                    'fechasTurnos_finAtencion' => $this->request->getPost('periodoAtencionHasta'),
                    'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('cantidadDias', 'int'),
                    'fechasTurnos_cantidadAutorizados' => $this->request->getPost('cantidadTurnos', 'int'),
                ));
                if ($fechasTurnos->save()) {
                    $this->flash->message('exito', 'La configuración de los períodos se ha realizado satisfactoriamente.');
                    $periodoSolicitudForm->clear();
                }
                $this->flash->error($fechasTurnos->getMessages());
            }
        }
    }


}

