<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class FormacionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Estudios');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

        parent::initialize();
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for formacion
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Formacion", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "formacion_id";

        $formacion = Curriculum\Formacion::find($parameters);
        if (count($formacion) == 0) {
            $this->flash->notice("The search did not find any formacion");

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $formacion,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction($curriculum_id)
    {
        $this->view->experienciaForm = new FormacionForm();
        $this->view->curriculumId = $curriculum_id;
    }

    /**
     * Edits a formacion
     *
     * @param string $formacion_id
     * @return null
     */
    public function editAction($formacion_id)
    {

        if (!$this->request->isPost()) {

            $formacion = Curriculum\Formacion::findFirstByformacion_id($formacion_id);
            if (!$formacion) {
                $this->flash->error("formacion was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "formacion",
                    "action" => "index"
                ));
            }

            $this->view->formacion_id = $formacion->formacion_id;

            $this->tag->setDefault("formacion_id", $formacion->getFormacionId());
            $this->tag->setDefault("formacion_curriculumId", $formacion->getFormacionCurriculumid());
            $this->tag->setDefault("formacion_institucion", $formacion->getFormacionInstitucion());
            $this->tag->setDefault("formacion_gradoId", $formacion->getFormacionGradoid());
            $this->tag->setDefault("formacion_titulo", $formacion->getFormacionTitulo());
            $this->tag->setDefault("formacion_estadoId", $formacion->getFormacionEstadoid());
            $this->tag->setDefault("formacion_fechaInicio", $formacion->getFormacionFechainicio());
            $this->tag->setDefault("formacion_fechaFinal", $formacion->getFormacionFechafinal());
            $this->tag->setDefault("formacion_fechaActual", $formacion->getFormacionFechaactual());
            $this->tag->setDefault("formacion_habilitado", $formacion->getFormacionHabilitado());

        }
    }

    /**
     * Creates a new formacion
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "index"
            ));
        }

        $formacion = new Curriculum\Formacion();
        $curriculumId = $this->request->getPost("curriculum_id");
        $formacion->setFormacionCurriculumid($curriculumId);

        $formacion->setFormacionInstitucion($this->request->getPost("formacion_institucion"));
        $formacion->setFormacionGradoid($this->request->getPost("formacion_gradoId"));
        $formacion->setFormacionTitulo($this->request->getPost("formacion_titulo"));
        $formacion->setFormacionEstadoid($this->request->getPost("formacion_estadoId"));
        $formacion->setFormacionFechainicio($this->request->getPost("formacion_fechaInicio"));
        if ($this->request->hasPost('formacion_fechaFinal')) {
            $formacion->setFormacionFechafinal($this->request->getPost("formacion_fechaFinal"));
            $formacion->setFormacionFechaactual(0);
        } else {
            $formacion->setFormacionFechafinal(NULL);
            $formacion->setFormacionFechaactual(1);
        }
        $formacion->setFormacionHabilitado(1);


        if (!$formacion->save()) {

            foreach ($formacion->getMessages() as $message) {
                $this->flash->message("problema", $message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "new"
            ));
        }
        /* Verifica que boton selecciono,tiene dos opciones:
        // continuar añadiendo informacion o pasar al siguiente nivel.
        */
        if (!empty($_POST['anadir'])) {
            $this->flash->message('exito', "Formación Académica agregada correctamente");
            $experienciaForm = new FormacionForm();
            $experienciaForm->clear();
            $this->view->experienciaForm = $experienciaForm;
            $this->view->curriculumId = $curriculumId;
            return $this->redireccionar('formacion/new/' . $curriculumId);
        } else {
            return $this->redireccionar('informacion/new/' . $curriculumId);
        }


    }

    /**
     * Saves a formacion edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "index"
            ));
        }

        $formacion_id = $this->request->getPost("formacion_id");

        $formacion = Curriculum\Formacion::findFirstByformacion_id($formacion_id);
        if (!$formacion) {
            $this->flash->error("formacion does not exist " . $formacion_id);

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "index"
            ));
        }

        $formacion->setFormacionCurriculumid($this->request->getPost("formacion_curriculumId"));
        $formacion->setFormacionInstitucion($this->request->getPost("formacion_institucion"));
        $formacion->setFormacionGradoid($this->request->getPost("formacion_gradoId"));
        $formacion->setFormacionTitulo($this->request->getPost("formacion_titulo"));
        $formacion->setFormacionEstadoid($this->request->getPost("formacion_estadoId"));
        $formacion->setFormacionFechainicio($this->request->getPost("formacion_fechaInicio"));
        $formacion->setFormacionFechafinal($this->request->getPost("formacion_fechaFinal"));
        $formacion->setFormacionFechaactual($this->request->getPost("formacion_fechaActual"));
        $formacion->setFormacionHabilitado($this->request->getPost("formacion_habilitado"));


        if (!$formacion->save()) {

            foreach ($formacion->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "edit",
                "params" => array($formacion->formacion_id)
            ));
        }

        $this->flash->success("formacion was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "formacion",
            "action" => "index"
        ));

    }

    /**
     * Deletes a formacion
     *
     * @param string $formacion_id
     * @return null
     */
    public function deleteAction($formacion_id)
    {

        $formacion = Curriculum\Formacion::findFirstByformacion_id($formacion_id);
        if (!$formacion) {
            $this->flash->error("formacion was not found");

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "index"
            ));
        }

        if (!$formacion->delete()) {

            foreach ($formacion->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "formacion",
                "action" => "search"
            ));
        }

        $this->flash->success("formacion was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "formacion",
            "action" => "index"
        ));
    }

}
