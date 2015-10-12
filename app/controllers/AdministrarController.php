<?php

class AdministrarController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('Administrador');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

        parent::initialize();

    }
    public function indexAction()
    {

    }

}

