<?php

class AdministrarController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('Administrador');
        $this->view->setTemplateAfter('main');
        parent::initialize();

    }
    public function indexAction()
    {

    }

}

