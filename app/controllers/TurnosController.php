<?php
use \Phalcon\Paginator\Adapter\Model as Paginacion;
use \Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class TurnosController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Turnos Online');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

        parent::initialize();

    }

    public function indexAction()
    {
        $this->view->formulario = new TurnosOnlineForm();

    }

    public function guardarSolicitudTurnoAction()
    {


    }

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
                    'fechasTurnos_cantidadDeTurnos' => $this->request->getPost('cantidadDias','int'),
                    'fechasTurnos_cantidadAutorizados' => $this->request->getPost('cantidadTurnos','int'),
                ));
                if ($fechasTurnos->save()) {
                    $this->flash->message('exito','La configuración de los períodos se ha realizado satisfactoriamente.');
                    $periodoSolicitudForm->clear();
                }
                $this->flash->error( $fechasTurnos->getMessages());
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
}

