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
      * @return
      */
    public function editAction($experiencia_id)
    {

        if ($this->request->isGet()) {
            $experiencia = \Curriculum\Experiencia::findFirstByexperiencia_id($experiencia_id);
            if (!$experiencia) {
                $this->flash->message("problema","La Experiencia Laboral no fue encontrada");
                return $this->dispatcher->forward(array(
                    "controller" => "curriculum",
                    "action" => "login"
                ));
            }
            $this->view->curriculum_id = $experiencia->getExperienciaCurriculumid();
            $this->view->form = new ExperienciaForm($experiencia, array('edit' => true));
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
                "action" => "login"
            ));
        }

        $experiencia_id = $this->request->getPost("experiencia_id");

        $experiencia = \Curriculum\Experiencia::findFirstByExperiencia_id($experiencia_id);
        if (!$experiencia) {
            $this->flash->message("problema","La experiencia laboral no existe - " . $experiencia_id);

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "login"
            ));
        }
        $this->view->form = new ExperienciaForm($experiencia, array('edit' => true));

        $experiencia->setExperienciaEmpresa($this->request->getPost("experiencia_empresa"));
        $experiencia->setExperienciaRubro($this->request->getPost("experiencia_rubro"));
        $experiencia->setExperienciaCargo($this->request->getPost("experiencia_cargo"));
        $experiencia->setExperienciaTareas($this->request->getPost("experiencia_tareas"));
        $experiencia->setExperienciaFechainicio($this->request->getPost("experiencia_fechaInicio"));
        if($this->request->hasPost('experiencia_fechaFinal'))
        {
            $experiencia->setExperienciaFechafinal($this->request->getPost("experiencia_fechaFinal"));
            $experiencia->setExperienciaFechaactual(0);
        }
        else{
            $experiencia->setExperienciaFechaactual($this->request->getPost("experiencia_fechaActual"));
        }
        $experiencia->setExperienciaProvinciaid($this->request->getPost("experiencia_provinciaId"));

        $this->db->begin();
        if (!$experiencia->save()) {

            foreach ($experiencia->getMessages() as $message) {
                $this->flash->message("problema",$message);
            }
            $this->db->rollback();
            return $this->redireccionar('experiencia/edit/'.$experiencia_id);
        }
        $curriculum = Curriculum\Curriculum::findFirstByCurriculum_id($experiencia->getExperienciaCurriculumid());
        if (!$curriculum) {
            $this->flash->message("problema","No se encontro el curriculum - " . $experiencia->getExperienciaCurriculumid());
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "login"
            ));
        }
        $curriculum->setCurriculumUltimamodificacion(date('Y-m-d'));
        if (!$curriculum->update()) {

            foreach ($curriculum->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->db->rollback();
            return $this->redireccionar('experiencia/edit/'.$experiencia_id);
        }
        $this->db->commit();
        $this->flash->notice("Los Datos Personales se han actualizado correctamente");
        return $this->redireccionar('curriculum/ver/'.$experiencia->getExperienciaCurriculumid());

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
