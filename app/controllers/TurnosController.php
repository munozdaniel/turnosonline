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
        $this->view->formulario = new PeriodoSolicitudForm();

        // Form is a simple <input type=text name=test> form
        if ($this->request->isPost()) {
            $validation = new Phalcon\Validation();
            //Aplico el DateValidator al campo de la vista (el primer atributo es el ID)
            //periodoSolicitudDesde < periodoSolicitudHasta
            $validation->add('periodoSolicitudDesde', new DateValidator(array(
                'verificarCampo' => '<strong>Período para solicitud de turnos</strong>',
                'hasta' => $this->request->getPost('periodoSolicitudHasta') // envio fecha a comparar
            )));

            $messages = $validation->validate($this->request->getPost());

            if (count($messages)) {
                // Validation failed here
                foreach ($messages as $m)
                    $this->flash->error('[<ins>ERROR</ins>] ' . $m->getMessage());
            }
            $this->view->pick('turnos/periodoSolicitud');
        }
    }
}

