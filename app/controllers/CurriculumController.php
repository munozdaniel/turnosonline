<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CurriculumController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Curriculum');
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
     * Searches for curriculum
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Curriculum", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "curriculum_id";

        $curriculum = \Curriculum\Curriculum::find($parameters);
        if (count($curriculum) == 0) {
            $this->flash->notice("The search did not find any curriculum");

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $curriculum,
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
     * Edits a curriculum
     *
     * @param string $curriculum_id
     */
    public function editAction($curriculum_id)
    {

        if (!$this->request->isPost()) {

            $curriculum = Curriculum::findFirstBycurriculum_id($curriculum_id);
            if (!$curriculum) {
                $this->flash->error("curriculum was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "curriculum",
                    "action" => "index"
                ));
            }

            $this->view->curriculum_id = $curriculum->curriculum_id;

            $this->tag->setDefault("curriculum_id", $curriculum->getCurriculumId());
            $this->tag->setDefault("curriculum_personaId", $curriculum->getCurriculumPersonaid());
            $this->tag->setDefault("curriculum_experienciaId", $curriculum->getCurriculumExperienciaid());
            $this->tag->setDefault("curriculum_formacionId", $curriculum->getCurriculumFormacionid());
            $this->tag->setDefault("curriculum_idiomasId", $curriculum->getCurriculumIdiomasid());
            $this->tag->setDefault("curriculum_informaticaId", $curriculum->getCurriculumInformaticaid());
            $this->tag->setDefault("curriculum_habilitado", $curriculum->getCurriculumHabilitado());
            
        }
    }

    /**
     * Creates a new curriculum
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "index"
            ));
        }

        $curriculum = new \Curriculum\Curriculum();

        $curriculum->setCurriculumPersonaid($this->request->getPost("curriculum_personaId"));
        $curriculum->setCurriculumExperienciaid($this->request->getPost("curriculum_experienciaId"));
        $curriculum->setCurriculumFormacionid($this->request->getPost("curriculum_formacionId"));
        $curriculum->setCurriculumIdiomasid($this->request->getPost("curriculum_idiomasId"));
        $curriculum->setCurriculumInformaticaid($this->request->getPost("curriculum_informaticaId"));
        $curriculum->setCurriculumHabilitado($this->request->getPost("curriculum_habilitado"));
        

        if (!$curriculum->save()) {
            foreach ($curriculum->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "new"
            ));
        }

        $this->flash->success("curriculum was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "curriculum",
            "action" => "index"
        ));

    }

    /**
     * Saves a curriculum edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "index"
            ));
        }

        $curriculum_id = $this->request->getPost("curriculum_id");

        $curriculum = \Curriculum\Curriculum::findFirstBycurriculum_id($curriculum_id);
        if (!$curriculum) {
            $this->flash->error("curriculum does not exist " . $curriculum_id);

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "index"
            ));
        }

        $curriculum->setCurriculumPersonaid($this->request->getPost("curriculum_personaId"));
        $curriculum->setCurriculumExperienciaid($this->request->getPost("curriculum_experienciaId"));
        $curriculum->setCurriculumFormacionid($this->request->getPost("curriculum_formacionId"));
        $curriculum->setCurriculumIdiomasid($this->request->getPost("curriculum_idiomasId"));
        $curriculum->setCurriculumInformaticaid($this->request->getPost("curriculum_informaticaId"));
        $curriculum->setCurriculumHabilitado($this->request->getPost("curriculum_habilitado"));
        

        if (!$curriculum->save()) {

            foreach ($curriculum->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "edit",
                "params" => array($curriculum->curriculum_id)
            ));
        }

        $this->flash->success("curriculum was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "curriculum",
            "action" => "index"
        ));

    }

    /**
     * Deletes a curriculum
     *
     * @param string $curriculum_id
     */
    public function deleteAction($curriculum_id)
    {

        $curriculum = \Curriculum\Curriculum::findFirstBycurriculum_id($curriculum_id);
        if (!$curriculum) {
            $this->flash->error("curriculum was not found");

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "index"
            ));
        }

        if (!$curriculum->delete()) {

            foreach ($curriculum->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "search"
            ));
        }

        $this->flash->success("curriculum was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "curriculum",
            "action" => "index"
        ));
    }
    /**
     * login action, Muestra un formulario para ingresar dni y email
     */
    public function loginAction()
    {
        $this->tag->setTitle('Iniciar Sesión');
        $this->view->form = new LoginForm();
    }

    /**
     * Verifica si esta registrado. En caso afirmativo redireccionar al verAction. En caso negativo
     * redireccion al new de Persona, para que se registre.
     */
    public function verificarDatosAction()
    {

        if (!$this->request->isPost()) {
            return $this->redireccionar('curriculum/login');
        }
        $formulario = new LoginForm();
        //si el formulario no pasa la validación que le hemos impuesto
        if ($formulario->isValid($this->request->getPost()) == false)
        {
            //mostramos los mensajes con la clase error que hemos personalizado en los mensajes flash
            foreach ($formulario->getMessages() as $message)
            {
                $this->flash->message('problema',$message);
            }
            return $this->redireccionar('curriculum/login');

        }else
        {
            $dni = $this->request->getPost('persona_numeroDocumento', array('int'));
            $email = $this->request->getPost('persona_email', array('email'));
            $condiciones = "persona_email LIKE :email: AND persona_numeroDocumento = :dni:";
            // Parameters whose keys are the same as placeholders
            $parametros = array(
                "email" => $email,
                "dni" => $dni
            );
            $persona = \Curriculum\Persona::find(
                array(
                    $condiciones,
                    "bind" => $parametros
                ));
            if (count($persona) == 0) {
                $this->view->formulario = new DatosPersonalesForm();
                return $this->redireccionar('persona/new');
            }else{
                $idCurriculum = \Curriculum\Curriculum::findFirstByCurriculum_personaId($persona->getPersonaId());
                return $this->redireccionar("curriculum/ver/$idCurriculum");
            }
        }
    }
    /**
     * Permite ver el curriculum completo
     */
    public function verAction($idCurriculum)
    {
        if($idCurriculum==null){
            $this->flash->message('problema','OPS! HUBO UN PROBLEMA AL RECUPERAR EL CURRICULUM');
        }
        $curriculum = \Curriculum\Curriculum::findFirstByCurriculum_id($idCurriculum);
        $this->view->personaForm = \Curriculum\Persona::findFirstByPersona_id($curriculum->getCurriculumPersonaId());
    }
}
