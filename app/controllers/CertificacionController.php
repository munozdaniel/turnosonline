<?php

class CertificacionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Certificación Negativa');
        parent::initialize();

    }

    public function indexAction()
    {
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
    }

}

