<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExperienciaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for experiencia
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Experiencia", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "experiencia_id";

        $experiencia = \Curriculum\Experiencia::find($parameters);
        if (count($experiencia) == 0) {
            $this->flash->notice("The search did not find any experiencia");

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $experiencia,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a experiencia
     *
     * @param string $experiencia_id
     */
    public function editAction($experiencia_id)
    {

        if (!$this->request->isPost()) {

            $experiencia = \Curriculum\Experiencia::findFirstByexperiencia_id($experiencia_id);
            if (!$experiencia) {
                $this->flash->error("experiencia was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "experiencia",
                    "action" => "index"
                ));
            }

            $this->view->experiencia_id = $experiencia->experiencia_id;

            $this->tag->setDefault("experiencia_id", $experiencia->getExperienciaId());
            $this->tag->setDefault("experiencia_curriculumId", $experiencia->getExperienciaCurriculumid());
            $this->tag->setDefault("experiencia_empresa", $experiencia->getExperienciaEmpresa());
            $this->tag->setDefault("experiencia_rubro", $experiencia->getExperienciaRubro());
            $this->tag->setDefault("experiencia_cargo", $experiencia->getExperienciaCargo());
            $this->tag->setDefault("experiencia_tareas", $experiencia->getExperienciaTareas());
            $this->tag->setDefault("experiencia_fechaInicio", $experiencia->getExperienciaFechainicio());
            $this->tag->setDefault("experiencia_fechaFinal", $experiencia->getExperienciaFechafinal());
            $this->tag->setDefault("experiencia_fechaActual", $experiencia->getExperienciaFechaactual());
            $this->tag->setDefault("experiencia_habilitado", $experiencia->getExperienciaHabilitado());
            $this->tag->setDefault("experiencia_provinciaId", $experiencia->getExperienciaProvinciaid());
            
        }
    }

    /**
     * Creates a new experiencia
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        $experiencia = new Experiencia();

        $experiencia->setExperienciaCurriculumid($this->request->getPost("experiencia_curriculumId"));
        $experiencia->setExperienciaEmpresa($this->request->getPost("experiencia_empresa"));
        $experiencia->setExperienciaRubro($this->request->getPost("experiencia_rubro"));
        $experiencia->setExperienciaCargo($this->request->getPost("experiencia_cargo"));
        $experiencia->setExperienciaTareas($this->request->getPost("experiencia_tareas"));
        $experiencia->setExperienciaFechainicio($this->request->getPost("experiencia_fechaInicio"));
        $experiencia->setExperienciaFechafinal($this->request->getPost("experiencia_fechaFinal"));
        $experiencia->setExperienciaFechaactual($this->request->getPost("experiencia_fechaActual"));
        $experiencia->setExperienciaHabilitado($this->request->getPost("experiencia_habilitado"));
        $experiencia->setExperienciaProvinciaid($this->request->getPost("experiencia_provinciaId"));
        

        if (!$experiencia->save()) {
            foreach ($experiencia->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "new"
            ));
        }

        $this->flash->success("experiencia was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "experiencia",
            "action" => "index"
        ));

    }

    /**
     * Saves a experiencia edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        $experiencia_id = $this->request->getPost("experiencia_id");

        $experiencia = \Curriculum\Experiencia::findFirstByexperiencia_id($experiencia_id);
        if (!$experiencia) {
            $this->flash->error("experiencia does not exist " . $experiencia_id);

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        $experiencia->setExperienciaCurriculumid($this->request->getPost("experiencia_curriculumId"));
        $experiencia->setExperienciaEmpresa($this->request->getPost("experiencia_empresa"));
        $experiencia->setExperienciaRubro($this->request->getPost("experiencia_rubro"));
        $experiencia->setExperienciaCargo($this->request->getPost("experiencia_cargo"));
        $experiencia->setExperienciaTareas($this->request->getPost("experiencia_tareas"));
        $experiencia->setExperienciaFechainicio($this->request->getPost("experiencia_fechaInicio"));
        $experiencia->setExperienciaFechafinal($this->request->getPost("experiencia_fechaFinal"));
        $experiencia->setExperienciaFechaactual($this->request->getPost("experiencia_fechaActual"));
        $experiencia->setExperienciaHabilitado($this->request->getPost("experiencia_habilitado"));
        $experiencia->setExperienciaProvinciaid($this->request->getPost("experiencia_provinciaId"));
        

        if (!$experiencia->save()) {

            foreach ($experiencia->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "edit",
                "params" => array($experiencia->experiencia_id)
            ));
        }

        $this->flash->success("experiencia was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "experiencia",
            "action" => "index"
        ));

    }

    /**
     * Deletes a experiencia
     *
     * @param string $experiencia_id
     */
    public function deleteAction($experiencia_id)
    {

        $experiencia = \Curriculum\Experiencia::findFirstByexperiencia_id($experiencia_id);
        if (!$experiencia) {
            $this->flash->error("experiencia was not found");

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        if (!$experiencia->delete()) {

            foreach ($experiencia->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "search"
            ));
        }

        $this->flash->success("experiencia was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "experiencia",
            "action" => "index"
        ));
    }

}
