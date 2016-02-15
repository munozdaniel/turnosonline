<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExperienciaController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Experiencia');
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
     * Agregar experiencia al curriculum.
     */
    public function newAction($curriculum_id)
    {

         $this->view->experienciaForm = new ExperienciaForm();
         $this->view->curriculumId = $curriculum_id;
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
                $this->flash->message("problema","experiencia was not found");

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
        //FIXME: Agregar
         if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "login"
            ));
        }

        $experiencia    = new Curriculum\Experiencia();
        $curriculumId   = $this->request->getPost("curriculum_id",array('int'));
        if ($curriculumId=="" || $curriculumId==null) {
            $this->flash->message('problema','Ocurrio un problema, no se pudo encontrar los datos referidos al curriculum.<br> Por favor comuniquese con nosotros vía email para resolver el problema. <br> Disculpe las molestias ocasionadas.');
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "login"
            ));
        }
        $experiencia->setExperienciaCurriculumid($this->request->getPost("curriculum_id",array('int')));
        $experiencia->setExperienciaEmpresa(strtoupper($this->request->getPost("experiencia_empresa",'string')));
        $experiencia->setExperienciaRubro(strtoupper($this->request->getPost("experiencia_rubro",'string')));
        $experiencia->setExperienciaCargo(strtoupper($this->request->getPost("experiencia_cargo",'string')));
        $experiencia->setExperienciaTareas(strtoupper($this->request->getPost("experiencia_tareas",'string')));
        $experiencia->setExperienciaFechainicio($this->request->getPost("experiencia_fechaInicio"));
        if($this->request->hasPost('experiencia_fechaFinal'))
        {
            $experiencia->setExperienciaFechafinal($this->request->getPost("experiencia_fechaFinal"));
            $experiencia->setExperienciaFechaactual(0);
        }
        else{
            $experiencia->setExperienciaFechaactual($this->request->getPost("experiencia_fechaActual"));
        }
        $experiencia->setExperienciaHabilitado(1);
        $experiencia->setExperienciaProvinciaid($this->request->getPost("experiencia_provinciaId"));
        

        if (!$experiencia->save()) {
            foreach ($experiencia->getMessages() as $message) {
                $this->flash->message("problema",$message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "new"
            ));
        }


        if (!empty($_POST['anadir'])) {
            $this->flash->message('exito',"Experiencia agregada correctamente");
            $experienciaForm   = new ExperienciaForm();
            $experienciaForm->clear();
            $this->view->experienciaForm   = $experienciaForm;
             $this->view->curriculumId      = $curriculumId;
             return $this->redireccionar('experiencia/new/'.$curriculumId);
        }else{
             return $this->redireccionar('formacion/new/'.$curriculumId);
        }
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
            $this->flash->message("problema","experiencia does not exist " . $experiencia_id);

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
                $this->flash->message("problema",$message);
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
            $this->flash->message("problema","experiencia was not found");

            return $this->dispatcher->forward(array(
                "controller" => "experiencia",
                "action" => "index"
            ));
        }

        if (!$experiencia->delete()) {

            foreach ($experiencia->getMessages() as $message) {
                $this->flash->message("problema",$message);
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
