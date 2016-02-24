<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IdiomasController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for idiomas
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Idiomas", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "idiomas_id";

        $idiomas = \Curriculum\Idiomas::find($parameters);
        if (count($idiomas) == 0) {
            $this->flash->notice("The search did not find any idiomas");

            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $idiomas,
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
     * Edits a idioma
     *
     * @param string $idiomas_id
     */
    public function editAction($idiomas_id)
    {

        if (!$this->request->isPost()) {

            $idioma = \Curriculum\Idiomas::findFirstByidiomas_id($idiomas_id);
            if (!$idioma) {
                $this->flash->error("idioma was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "idiomas",
                    "action" => "index"
                ));
            }

            $this->view->idiomas_id = $idioma->idiomas_id;

            $this->tag->setDefault("idiomas_id", $idioma->getIdiomasId());
            $this->tag->setDefault("idiomas_curriculumId", $idioma->getIdiomasCurriculumid());
            $this->tag->setDefault("idiomas_nombre", $idioma->getIdiomasNombre());
            $this->tag->setDefault("idiomas_nivelId", $idioma->getIdiomasNivelid());
            $this->tag->setDefault("nivel_habilitado", $idioma->getNivelHabilitado());
            
        }
    }

    /**
     * Creates a new idioma
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "index"
            ));
        }

        $idioma = new \Curriculum\Idiomas();

        $idioma->setIdiomasCurriculumid($this->request->getPost("idiomas_curriculumId"));
        $idioma->setIdiomasNombre($this->request->getPost("idiomas_nombre"));
        $idioma->setIdiomasNivelid($this->request->getPost("idiomas_nivelId"));
        $idioma->setNivelHabilitado($this->request->getPost("nivel_habilitado"));
        

        if (!$idioma->save()) {
            foreach ($idioma->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "new"
            ));
        }

        $this->flash->success("idioma was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "idiomas",
            "action" => "index"
        ));

    }

    /**
     * Saves a idioma edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "index"
            ));
        }

        $idiomas_id = $this->request->getPost("idiomas_id");

        $idioma = \Curriculum\Idiomas::findFirstByidiomas_id($idiomas_id);
        if (!$idioma) {
            $this->flash->error("idioma does not exist " . $idiomas_id);

            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "index"
            ));
        }

        $idioma->setIdiomasCurriculumid($this->request->getPost("idiomas_curriculumId"));
        $idioma->setIdiomasNombre($this->request->getPost("idiomas_nombre"));
        $idioma->setIdiomasNivelid($this->request->getPost("idiomas_nivelId"));
        $idioma->setNivelHabilitado($this->request->getPost("nivel_habilitado"));
        

        if (!$idioma->save()) {

            foreach ($idioma->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "idiomas",
                "action" => "edit",
                "params" => array($idioma->idiomas_id)
            ));
        }

        $this->flash->success("idioma was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "idiomas",
            "action" => "index"
        ));

    }

    /**
     * Deletes a idioma
     *
     * @param string $idiomas_id
     */
    public function deleteAction($idiomas_id)
    {
        $this->view->disable();
        $data = array();
        $data['success']=true;
        $errores = array();
        $idioma = \Curriculum\Idiomas::findFirstByidiomas_id($idiomas_id);
        if (!$idioma) {
            $data['success']=false;
            $date['mensaje']="El idioma no se ha encontrado";
        }

        if (!$idioma->delete()) {

            foreach ($idioma->getMessages() as $message) {
                $errores[] = $message . "<br>";
            }
            $data['success']=false;
            $date['mensaje']=$errores;
        }

        if($data['success'])
            $data['mensaje']="Operación Exitosa";
        $this->response->setJsonContent($data);
        $this->response->send();
    }

    /**
     * Permite agregar un idioma a traves de ajax.
     */
    public function agregarAction(){
        $this->view->disable();

        if($this->request->isPost())
        {
            if($this->request->isAjax())
            {
                $idiomaForm = new IdiomaForm();
                $idioma     = new \Curriculum\Idiomas();
                $datosPost  = $this->request->getPost();
                if($idiomaForm->isValid($datosPost,$idioma) == false){
                    $data['success'] = false;
                    $data['errors']  = $this->mensajesError($datosPost,$idiomaForm) ;
                }else {
                    $idioma->setIdiomasNombre(strtoupper($idioma->getIdiomasNombre()));
                    $idioma->setIdiomasCurriculumid($this->request->getPost('curriculum_id'));
                    $idioma->setIdiomasHabilitado(1);
                    if($idioma->save() == false)
                    {
                        $data['success'] = false;
                        $mensaje = "";
                        foreach ($idioma->getMessages() as $message) {
                            $mensaje .=  $message . " <br>";
                        }
                        $errors=array();
                        $errors['notSave']=$mensaje;
                        $data['errors']  = $errors;
                    }else{
                        $data['success'] = true;
                    }
                }

                $this->response->setJsonContent($data);
                $this->response->send();
            }
        }
    }

    /**
     * Verifica cuales fueron los campos enviados por post que no cumplen con las validaciones correspondientes
     * y devuelve un arreglo que contiene los campos con el mensaje correspondiente.
     * @param $datosPost
     * @param $form
     * @return array
     */
    private function mensajesError($datosPost, $form){
        $atributos = array();
        foreach($datosPost as $clave => $valor)
            $atributos[] = $clave;
        $errors=array();
        $i=0;
        foreach ($form->getMessages() as $mensaje) {
            $errors[$atributos[$i]]=$mensaje."";
            $i++;
        }
        return $errors;
    }

    public function buscarIdiomasPorCurriculumAction(){
        $this->view->disable();

        if($this->request->isPost()) {
            $idiomas = \Curriculum\Idiomas::findByIdiomas_curriculumId($this->request->getPost('curriculum_id'));
            if(count($idiomas)==0){
                $data['success'] = false;
                $data['mensaje'] = array("No hay idiomas cargados.");
            }else{
                $data['success'] = true;
                $data['mensaje'] = array("Operación Correcta");
                $arregloIdiomas = array();
                foreach($idiomas as $unIdioma){
                    $idio = array();
                    $idio['nombre']=$unIdioma->getIdiomasNombre();
                    $idio['nivel']=$unIdioma->getNivel()->getNivelNombre();
                    $idio['idiomas_id']=$unIdioma->getIdiomasId();
                    $arregloIdiomas[]=$idio;
                }
                $data['idiomas'] = $arregloIdiomas;
            }
            $this->response->setJsonContent($data);
            $this->response->send();
        }
    }

}
