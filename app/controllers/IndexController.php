<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {

        parent::initialize();

    }
    public function indexAction()
    {
        return $this->response->redirect('sesion/index');
    }

}

