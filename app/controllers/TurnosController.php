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

                //Si todo esta bien:
                $solicitudTurno = new Solicitudturno();
                if ($solicitudTurno->save()) {
                    //return $this->redireccionar('administrar/index');
                }

                $this->flash->error('[<ins>ERROR</ins>] ' . $solicitudTurno->getMessages());
            }
        }
    }
}

