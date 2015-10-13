<?php

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
}

