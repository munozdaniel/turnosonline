<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class EmpleoController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for empleo
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Empleo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "empleo_id";

        $empleo = \Curriculum\Empleo::find($parameters);
        if (count($empleo) == 0) {
            $this->flash->notice("The search did not find any empleo");

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $empleo,
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
     * Edits a empleo
     *
     * @param string $empleo_id
     */
    public function editAction($empleo_id)
    {

        if (!$this->request->isPost()) {

            $empleo = \Curriculum\Empleo::findFirstByempleo_id($empleo_id);
            if (!$empleo) {
                $this->flash->error("empleo was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "empleo",
                    "action" => "index"
                ));
            }

            $this->view->empleo_id = $empleo->empleo_id;

            $this->tag->setDefault("empleo_id", $empleo->getEmpleoId());
            $this->tag->setDefault("empleo_curriculumId", $empleo->getEmpleoCurriculumid());
            $this->tag->setDefault("empleo_disponibilidad", $empleo->getEmpleoDisponibilidad());
            $this->tag->setDefault("empleo_carnet", $empleo->getEmpleoCarnet());
            $this->tag->setDefault("empleo_sectorInteresId", $empleo->getEmpleoSectorinteresid());
            $this->tag->setDefault("empleo_puestoId", $empleo->getEmpleoPuestoid());
            $this->tag->setDefault("empleo_habilitado", $empleo->getEmpleoHabilitado());
            
        }
    }

    /**
     * Creates a new empleo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "index"
            ));
        }

        $empleo = new \Curriculum\Empleo();

        $empleo->setEmpleoId($this->request->getPost("empleo_id"));
        $empleo->setEmpleoCurriculumid($this->request->getPost("empleo_curriculumId"));
        $empleo->setEmpleoDisponibilidad($this->request->getPost("empleo_disponibilidad"));
        $empleo->setEmpleoCarnet($this->request->getPost("empleo_carnet"));
        $empleo->setEmpleoSectorinteresid($this->request->getPost("empleo_sectorInteresId"));
        $empleo->setEmpleoPuestoid($this->request->getPost("empleo_puestoId"));
        $empleo->setEmpleoHabilitado($this->request->getPost("empleo_habilitado"));
        

        if (!$empleo->save()) {
            foreach ($empleo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "new"
            ));
        }

        $this->flash->success("empleo was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "empleo",
            "action" => "index"
        ));

    }

    /**
     * Saves a empleo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "index"
            ));
        }

        $empleo_id = $this->request->getPost("empleo_id");

        $empleo = \Curriculum\Empleo::findFirstByempleo_id($empleo_id);
        if (!$empleo) {
            $this->flash->error("empleo does not exist " . $empleo_id);

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "index"
            ));
        }

        $empleo->setEmpleoId($this->request->getPost("empleo_id"));
        $empleo->setEmpleoCurriculumid($this->request->getPost("empleo_curriculumId"));
        $empleo->setEmpleoDisponibilidad($this->request->getPost("empleo_disponibilidad"));
        $empleo->setEmpleoCarnet($this->request->getPost("empleo_carnet"));
        $empleo->setEmpleoSectorinteresid($this->request->getPost("empleo_sectorInteresId"));
        $empleo->setEmpleoPuestoid($this->request->getPost("empleo_puestoId"));
        $empleo->setEmpleoHabilitado($this->request->getPost("empleo_habilitado"));
        

        if (!$empleo->save()) {

            foreach ($empleo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "edit",
                "params" => array($empleo->empleo_id)
            ));
        }

        $this->flash->success("empleo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "empleo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a empleo
     *
     * @param string $empleo_id
     */
    public function deleteAction($empleo_id)
    {

        $empleo = \Curriculum\Empleo::findFirstByempleo_id($empleo_id);
        if (!$empleo) {
            $this->flash->error("empleo was not found");

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "index"
            ));
        }

        if (!$empleo->delete()) {

            foreach ($empleo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "empleo",
                "action" => "search"
            ));
        }

        $this->flash->success("empleo was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "empleo",
            "action" => "index"
        ));
    }
    /**
     *
     */
    public function agregarAction(){
        $this->view->disable();
        $data = array();
        $mensaje = array();
        if($this->request->isPost())
        {
            $empleo = new \Curriculum\Empleo();
            $empleo->setEmpleoCurriculumid($this->request->getPost('curriculum_id','int'));
            $empleo->setEmpleoCarnet($this->request->getPost('empleo_carnet','int'));
            $empleo->setEmpleoDisponibilidad($this->request->getPost('empleo_disponibilidad','string'));
            if($this->request->getPost('sectorInteres_id')!=null)
                $empleo->setEmpleoSectorinteresid($this->request->getPost('sectorInteres_id','int'));
            $empleo->setEmpleoPuestoid($this->request->getPost('puesto_id','int'));
            $empleo->setEmpleoPuestootro($this->request->getPost('puesto_otro'));
            $empleo->setEmpleoHabilitado(1);
            if(!$empleo->save()){
                foreach($empleo->getMessages() as $mje){
                    $mensaje[] = $mje . "<br>";
                }
                $data['success']=false;
            }
            else{
                $data['success']=true;
                $mensaje = "Operación Exitosa . ".$this->request->getPost('puesto_otro','string');
            }
        }else{
            $data['success']=false;
            $mensaje = "Ops, hubo un problema. Reingrese nuevamente.";
        }
        $data['mensaje']=$mensaje;
        $this->response->setJsonContent($data);
        $this->response->send();
    }
}
