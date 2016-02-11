<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ConocimientosController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for conocimientos
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Conocimientos", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "conocimientos_id";

        $conocimientos = \Curriculum\Conocimientos::find($parameters);
        if (count($conocimientos) == 0) {
            $this->flash->notice("The search did not find any conocimientos");

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $conocimientos,
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
     * Edits a conocimiento
     *
     * @param string $conocimientos_id
     */
    public function editAction($conocimientos_id)
    {

        if (!$this->request->isPost()) {

            $conocimiento = \Curriculum\Conocimientos::findFirstByconocimientos_id($conocimientos_id);
            if (!$conocimiento) {
                $this->flash->error("conocimiento was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "conocimientos",
                    "action" => "index"
                ));
            }

            $this->view->conocimientos_id = $conocimiento->conocimientos_id;

            $this->tag->setDefault("conocimientos_id", $conocimiento->getConocimientosId());
            $this->tag->setDefault("conocimientos_curriculumId", $conocimiento->getConocimientosCurriculumid());
            $this->tag->setDefault("conocimientos_nombre", $conocimiento->getConocimientosNombre());
            $this->tag->setDefault("conocimientos_nivelId", $conocimiento->getConocimientosNivelid());
            $this->tag->setDefault("conocimientos_habilitado", $conocimiento->getConocimientosHabilitado());
            
        }
    }

    /**
     * Creates a new conocimiento
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "index"
            ));
        }

        $conocimiento = new \Curriculum\Conocimientos();

        $conocimiento->setConocimientosCurriculumid($this->request->getPost("conocimientos_curriculumId"));
        $conocimiento->setConocimientosNombre($this->request->getPost("conocimientos_nombre"));
        $conocimiento->setConocimientosNivelid($this->request->getPost("conocimientos_nivelId"));
        $conocimiento->setConocimientosHabilitado($this->request->getPost("conocimientos_habilitado"));
        

        if (!$conocimiento->save()) {
            foreach ($conocimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "new"
            ));
        }

        $this->flash->success("conocimiento was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "conocimientos",
            "action" => "index"
        ));

    }
    public function agregarAction()
    {
        $errors = array();
        $data = array();
        $this->view->disable();
        if($this->request->isPost()){
            $conocimiento= new \Curriculum\Conocimientos();
            $conocimiento->setConocimientosCurriculumid($this->request->getPost('curriculum_id'));
            $conocimiento->setConocimientosHabilitado(1);
            $conocimiento->setConocimientosNivelid($this->request->getPost('conocimientos_nivelId'));
            $conocimiento->setConocimientosNombre(strtoupper($this->request->getPost('conocimientos_nombre')));
            if(!$conocimiento->validation())
            {
                foreach($conocimiento->getMessages() as $mensaje)
                {
                    $errors[] = $mensaje ." <br>";
                }
                $data['success']=false;
                $data['mensaje'] = $errors;
            }
            else{
                if(!$conocimiento->save()){
                foreach($conocimiento->getMessages() as $mensaje)
                {
                    $errors[] = $mensaje ." <br>";
                }
                $data['success']=false;
                $data['mensaje'] = $errors;
                }else{
                $data['success']=true;
                $data['mensaje']="Operación Correcta";

                }
            }
        }else{
            $data['success']=false;
            $data['mensaje']="Ops! Ocurrio un problema.";
        }
        $this->response->setJsonContent($data);
        $this->response->send();

    }

    /**
     * Saves a conocimiento edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "index"
            ));
        }

        $conocimientos_id = $this->request->getPost("conocimientos_id");

        $conocimiento = \Curriculum\Conocimientos::findFirstByconocimientos_id($conocimientos_id);
        if (!$conocimiento) {
            $this->flash->error("conocimiento does not exist " . $conocimientos_id);

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "index"
            ));
        }

        $conocimiento->setConocimientosCurriculumid($this->request->getPost("conocimientos_curriculumId"));
        $conocimiento->setConocimientosNombre($this->request->getPost("conocimientos_nombre"));
        $conocimiento->setConocimientosNivelid($this->request->getPost("conocimientos_nivelId"));
        $conocimiento->setConocimientosHabilitado($this->request->getPost("conocimientos_habilitado"));
        

        if (!$conocimiento->save()) {

            foreach ($conocimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "edit",
                "params" => array($conocimiento->conocimientos_id)
            ));
        }

        $this->flash->success("conocimiento was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "conocimientos",
            "action" => "index"
        ));

    }

    /**
     * Deletes a conocimiento
     *
     * @param string $conocimientos_id
     */
    public function deleteAction($conocimientos_id)
    {

        $conocimiento = \Curriculum\Conocimientos::findFirstByconocimientos_id($conocimientos_id);
        if (!$conocimiento) {
            $this->flash->error("conocimiento was not found");

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "index"
            ));
        }

        if (!$conocimiento->delete()) {

            foreach ($conocimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "conocimientos",
                "action" => "search"
            ));
        }

        $this->flash->success("conocimiento was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "conocimientos",
            "action" => "index"
        ));
    }

}
