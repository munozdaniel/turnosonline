<?php

/**
 * Class InformacionController
 * Se encarga de unir varios modelos  en una sola vista: Idioma, Conocimientos, Adicional y Puesto.
 */
class InformacionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Información General');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

        parent::initialize();
    }

    public function indexAction()
    {

    }
    public function newAction($curriculum_id)
    {
        //FIXME: Habilitar isPost
      /*  if(!$this->request->isGet() || $curriculum_id== null){
            $this->flash->message('problema','Momentaneamente no es posible acceder a la url solicitada');
            $this->response->redirect('curriculum/login');
        }*/
        $this->view->informacionForm = new InformacionForm();
        $this->view->idiomaForm = new IdiomaForm();
        $this->view->curriculumId = $curriculum_id;
    }

}

