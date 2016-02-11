<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PuestoController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Puestos');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')
            ->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

        parent::initialize();
    }
    /**
     * Se utiliza para cargar los puestos dinamicamente a partir de la dependencia que seleccione el usuario
     */
    public function buscarPuestosAction(){
        $this->view->disable();

        if($this->request->isPost())
        {
            if($this->request->isAjax())
            {
                $id= $this->request->getPost("id","int");
                $puestosPorDependencia = \Curriculum\Puesto::findByPuesto_dependenciaId($id);
                foreach ($puestosPorDependencia as $item) {
                    $resData[]= array("puesto_id"=>$item->getPuestoId(), "puesto_nombre"=>$item->getPuestoNombre());
                }
                if (count($puestosPorDependencia) > 0)
                {
                    $this->response->setJsonContent(array("lista"=>$resData));
                    $this->response->setStatusCode(200,"OK");
                }
                else
                    $this->response->setStatusCode(404, "Not Found");

                $this->response->send();
            }
        }
    }
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for puesto
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Puesto", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "puesto_id";

        $puesto = \Curriculum\Puesto::find($parameters);
        if (count($puesto) == 0) {
            $this->flash->notice("The search did not find any puesto");

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $puesto,
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
     * Edits a puesto
     *
     * @param string $puesto_id
     */
    public function editAction($puesto_id)
    {

        if (!$this->request->isPost()) {

            $puesto = \Curriculum\Puesto::findFirstBypuesto_id($puesto_id);
            if (!$puesto) {
                $this->flash->error("puesto was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "puesto",
                    "action" => "index"
                ));
            }

            $this->view->puesto_id = $puesto->puesto_id;

            $this->tag->setDefault("puesto_id", $puesto->getPuestoId());
            $this->tag->setDefault("puesto_nombre", $puesto->getPuestoNombre());
            $this->tag->setDefault("puesto_otro", $puesto->getPuestoOtro());
            $this->tag->setDefault("puesto_dependenciaId", $puesto->getPuestoDependenciaid());
            $this->tag->setDefault("puesto_habilitado", $puesto->getPuestoHabilitado());
            
        }
    }

    /**
     * Creates a new puesto
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "index"
            ));
        }

        $puesto = new Curriculum\Puesto();

        $puesto->setPuestoNombre($this->request->getPost("puesto_nombre"));
        $puesto->setPuestoOtro($this->request->getPost("puesto_otro"));
        $puesto->setPuestoDependenciaid($this->request->getPost("puesto_dependenciaId"));
        $puesto->setPuestoHabilitado($this->request->getPost("puesto_habilitado"));
        

        if (!$puesto->save()) {
            foreach ($puesto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "new"
            ));
        }

        $this->flash->success("puesto was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "puesto",
            "action" => "index"
        ));

    }

    /**
     * Saves a puesto edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "index"
            ));
        }

        $puesto_id = $this->request->getPost("puesto_id");

        $puesto = \Curriculum\Puesto::findFirstBypuesto_id($puesto_id);
        if (!$puesto) {
            $this->flash->error("puesto does not exist " . $puesto_id);

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "index"
            ));
        }

        $puesto->setPuestoNombre($this->request->getPost("puesto_nombre"));
        $puesto->setPuestoOtro($this->request->getPost("puesto_otro"));
        $puesto->setPuestoDependenciaid($this->request->getPost("puesto_dependenciaId"));
        $puesto->setPuestoHabilitado($this->request->getPost("puesto_habilitado"));
        

        if (!$puesto->save()) {

            foreach ($puesto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "edit",
                "params" => array($puesto->puesto_id)
            ));
        }

        $this->flash->success("puesto was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "puesto",
            "action" => "index"
        ));

    }

    /**
     * Deletes a puesto
     *
     * @param string $puesto_id
     */
    public function deleteAction($puesto_id)
    {

        $puesto = \Curriculum\Puesto::findFirstBypuesto_id($puesto_id);
        if (!$puesto) {
            $this->flash->error("puesto was not found");

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "index"
            ));
        }

        if (!$puesto->delete()) {

            foreach ($puesto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "puesto",
                "action" => "search"
            ));
        }

        $this->flash->success("puesto was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "puesto",
            "action" => "index"
        ));
    }

}
