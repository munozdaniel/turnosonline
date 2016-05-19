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
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $miSesion = $this->session->get('auth');
        $rol = $miSesion['rol_nombre'];
        $this->view->admin = false;
        $this->view->supervisor = false;
        $this->view->empleado = false;
        $this->view->rrhh = false;

        if ($rol == "ADMIN")
            $this->view->admin = true;
        else {
            if ($rol == "SUPERVISOR")
                $this->view->supervisor = true;
            else {
                if ($rol == "EMPLEADO")
                    $this->view->empleado = true;
                else {
                    if ($rol == "RRHH")
                        $this->view->rrhh = true;
                }
            }
        }
    }

}

