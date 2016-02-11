<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class InformaticaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for informatica
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Informatica", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "informatica_id";

        $informatica = \Curriculum\Informatica::find($parameters);
        if (count($informatica) == 0) {
            $this->flash->notice("The search did not find any informatica");

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $informatica,
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
     * Edits a informatica
     *
     * @param string $informatica_id
     */
    public function editAction($informatica_id)
    {

        if (!$this->request->isPost()) {

            $informatica = \Curriculum\Informatica::findFirstByinformatica_id($informatica_id);
            if (!$informatica) {
                $this->flash->error("informatica was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "informatica",
                    "action" => "index"
                ));
            }

            $this->view->informatica_id = $informatica->informatica_id;

            $this->tag->setDefault("informatica_id", $informatica->getInformaticaId());
            $this->tag->setDefault("informatica_curriculumId", $informatica->getInformaticaCurriculumid());
            $this->tag->setDefault("informatica_nombre", $informatica->getInformaticaNombre());
            $this->tag->setDefault("informatica_nivelId", $informatica->getInformaticaNivelid());
            $this->tag->setDefault("informatica_habilitado", $informatica->getInformaticaHabilitado());
            
        }
    }

    /**
     * Creates a new informatica
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "index"
            ));
        }

        $informatica = new \Curriculum\Informatica();

        $informatica->setInformaticaCurriculumid($this->request->getPost("informatica_curriculumId"));
        $informatica->setInformaticaNombre($this->request->getPost("informatica_nombre"));
        $informatica->setInformaticaNivelid($this->request->getPost("informatica_nivelId"));
        $informatica->setInformaticaHabilitado($this->request->getPost("informatica_habilitado"));
        

        if (!$informatica->save()) {
            foreach ($informatica->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "new"
            ));
        }

        $this->flash->success("informatica was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "informatica",
            "action" => "index"
        ));

    }

    /**
     * Saves a informatica edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "index"
            ));
        }

        $informatica_id = $this->request->getPost("informatica_id");

        $informatica = \Curriculum\Informatica::findFirstByinformatica_id($informatica_id);
        if (!$informatica) {
            $this->flash->error("informatica does not exist " . $informatica_id);

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "index"
            ));
        }

        $informatica->setInformaticaCurriculumid($this->request->getPost("informatica_curriculumId"));
        $informatica->setInformaticaNombre($this->request->getPost("informatica_nombre"));
        $informatica->setInformaticaNivelid($this->request->getPost("informatica_nivelId"));
        $informatica->setInformaticaHabilitado($this->request->getPost("informatica_habilitado"));
        

        if (!$informatica->save()) {

            foreach ($informatica->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "edit",
                "params" => array($informatica->informatica_id)
            ));
        }

        $this->flash->success("informatica was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "informatica",
            "action" => "index"
        ));

    }

    /**
     * Deletes a informatica
     *
     * @param string $informatica_id
     */
    public function deleteAction($informatica_id)
    {

        $informatica = \Curriculum\Informatica::findFirstByinformatica_id($informatica_id);
        if (!$informatica) {
            $this->flash->error("informatica was not found");

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "index"
            ));
        }

        if (!$informatica->delete()) {

            foreach ($informatica->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "informatica",
                "action" => "search"
            ));
        }

        $this->flash->success("informatica was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "informatica",
            "action" => "index"
        ));
    }

}
