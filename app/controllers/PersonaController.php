<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Crypt;

class PersonaController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Datos Personales');
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
     * Searches for persona
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Persona", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "persona_id";

        $persona = \Curriculum\Persona::find($parameters);
        if (count($persona) == 0) {
            $this->flash->notice("No se han encontrado resultados");

            return $this->dispatcher->forward(array(
                "controller" => "persona",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $persona,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->formulario = new DatosPersonalesForm();
        $email = $this->request->get('email');
        $email = base64_decode($email);
        $this->tag->setDefault("persona_email", $email);
    }

    /**
     * Edits a persona
     * @param string $persona_id
     * @return
     */
    public function editAction()
    {
        if(!$this->request->isPost()){
            return $this->redireccionar('curriculum/login');
        }
        $persona_id = $this->request->getPost('persona_id');
        $persona = Curriculum\Persona::findFirstBypersona_id($persona_id);
        if (!$persona) {
            $this->flash->error("La persona no fue encontrada");
            return $this->redireccionar('curriculum/login');
        }
        if ($this->security->checkToken()) {
            $this->view->form = new DatosPersonalesForm($persona, array('edit' => true));
            $this->view->curriculum_id = $persona->getPersonaCurriculumid();

            $this->tag->setDefault("localidad_codigoPostal", $persona->getLocalidad()->getLocalidadCodigopostal());
            $this->tag->setDefault("provincia_id", $persona->getLocalidad()->getCiudad()->getProvincia()->getProvinciaId());
            $this->tag->setDefault("ciudad_id", $persona->getLocalidad()->getCiudad()->getCiudadId());
            $this->tag->setDefault("localidad_domicilio", $persona->getLocalidad()->getLocalidadDomicilio());
        }else{
            return $this->redireccionar('curriculum/ver/'.$persona->getPersonaCurriculumId());

        }
    }

    /**
     * Permite cargar el combobox Ciudad segun la provincia que se seleccione.
     * Deberia ir en el controlador ciudad, y habilitar el acceso ACL
     */
    public function buscarCiudadesAction()
    {
        $this->view->disable();

        if($this->request->isPost())
        {
            if($this->request->isAjax())
            {
                $id= $this->request->getPost("id","int");
                $ciudadesPorProvincia = \Curriculum\Ciudad::findByCiudad_provinciaId($id);
                foreach ($ciudadesPorProvincia as $ciudad) {
                    $resData[]= array("ciudad_id"=>$ciudad->ciudad_id, "ciudad_nombre"=>$ciudad->ciudad_nombre);
                }
                if (count($ciudadesPorProvincia) > 0)
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
     * Creates a new persona
     */
    public function createAction()
    {
        //echo  $_FILES['curriculum_adjunto']['name'] . " - ".$_FILES['curriculum_adjunto']['type'];
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "persona",
                "action" => "new"
            ));
        }
        try {
            /*====================== VALIDAR FORMULARIOS ================*/

            $formulario = new DatosPersonalesForm();
            //si el formulario no pasa la validación que le hemos impuesto
            if ($formulario->isValid($this->request->getPost()) == false) {
                foreach ($formulario->getMessages() as $message) {
                    $this->flash->message('problema',$message);
                }
                $formulario->clear(array('provincia_id','ciudad_id'));
                return $this->redireccionar('persona/new');
            }

            $this->db->begin();
            /*==================== CURRICULUM =========================*/
            $curriculum = new \Curriculum\Curriculum();
            $curriculum->setCurriculumHabilitado(1);
            $curriculum->setCurriculumFechacreacion(date('Y-m-d'));
            $curriculum->setCurriculumUltimamodificacion(date('Y-m-d'));
            /** Agregar curriculum pdf */
            if($_FILES['curriculum_adjunto']['name']!=""){

                if($_FILES['curriculum_adjunto']['type']=="application/pdf")
            {
                $limite_kb = 2000;
                if ( $_FILES['curriculum_adjunto']['size'] <= $limite_kb * 1024){
                    $ruta = "files/curriculum/pdf/" . $this->request->getPost("persona_numeroDocumento",array('int')).".pdf";
                    $resultado = move_uploaded_file($_FILES["curriculum_adjunto"]["tmp_name"], $ruta);
                    if($resultado)
                        $curriculum->setCurriculumAdjunto($ruta);
                    else
                        $this->flash->message('problema','El archivo adjunto no se pudo guardar, intentelo más tarde.');

                }else
                {
                    $this->flash->message('problema','El tamaño del pdf supera el limite (2mb)');
                    return $this->dispatcher->forward(array(
                        "controller" => "persona",
                        "action" => "new"
                    ));
                }
            }else{
                $this->flash->message('problema','El Curriculum adjunto debe ser un pdf');
                return $this->dispatcher->forward(array(
                    "controller" => "persona",
                    "action" => "new"
                ));

            }
            }else{
                $this->flash->message('problema','Curriculum adjunto es null');
                return $this->dispatcher->forward(array(
                    "controller" => "persona",
                    "action" => "new"
                ));
            }
            /** Fin: Agregar Curriculum Pdf*/
            if (!$curriculum->save()) {
                foreach ($curriculum->getMessages() as $message) {
                    $this->flash->message('problema',$message);
                }
                $this->db->rollback();
                return $this->redireccionar('persona/new');
            }

            /*==================== DATOS PERSONALES =========================*/
            $persona = new \Curriculum\Persona();
            /** Agregar foto*/
            if($_FILES['curriculum_foto']['name']!=""){
                if($_FILES['curriculum_foto']['type']=="image/jpeg" || $_FILES['curriculum_foto']['type']=="image/jpg")
                {
                    $limite_kb = 4000;
                    $dimensiones = getimagesize(rtrim($_FILES["curriculum_foto"]["tmp_name"]));
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if ( $_FILES['curriculum_foto']['size'] <= $limite_kb * 1024
                           && $ancho <=300 && $alto<=400 ){
                        $ruta = "files/curriculum/perfil/" . $this->request->getPost("persona_numeroDocumento",array('int')).".jpg";
                        $resultado = move_uploaded_file($_FILES["curriculum_foto"]["tmp_name"], $ruta);
                        if($resultado)
                            $persona->setPersonaFoto($ruta);
                        else
                            $this->flash->message('problema','La foto de perfil no se pudo guardar, intentelo más tarde.');

                    }else
                    {
                        $this->flash->message('problema','La foto de perfil no debe supera los 4mb y sus dimensiones deben ser 300x400 máx.');
                        return $this->dispatcher->forward(array(
                            "controller" => "persona",
                            "action" => "new"
                        ));
                    }
                }else{
                    $this->flash->message('problema','La foto de perfil debe ser un jpg');
                    return $this->dispatcher->forward(array(
                        "controller" => "persona",
                        "action" => "new"
                    ));

                }
            }else{
                $this->flash->message('problema','Curriculum foto es null');
                return $this->dispatcher->forward(array(
                    "controller" => "persona",
                    "action" => "new"
                ));
            }
            /** Fin: Agregar foto*/
            $persona->setPersonaCurriculumid($curriculum->getCurriculumId());
            $persona->setPersonaApellido($this->request->getPost("persona_apellido"),array('string'));
            $persona->setPersonaNombre($this->request->getPost("persona_nombre",array('string')));
            $persona->setPersonaFechanacimiento($this->request->getPost("persona_fechaNacimiento"));
            $persona->setPersonaTipodocumentoid($this->request->getPost("persona_tipoDocumentoId",'int'));
            $persona->setPersonaNumerodocumento($this->request->getPost("persona_numeroDocumento",array('int')));
            $persona->setPersonaSexo($this->request->getPost("persona_sexo",'int'));
            $persona->setPersonaNacionalidadid($this->request->getPost("persona_nacionalidadId",'int'));
            /*Agregar localidad*/
            $localidad = new \Curriculum\Localidad();
            $localidad->setLocalidadCodigopostal($this->request->getPost('localidad_codigoPostal','int'));
            $localidad->setLocalidadDomicilio($this->request->getPost('localidad_domicilio','string'));
            $localidad->setLocalidadCiudadid($this->request->getPost('ciudad_id','int'));
            if (!$localidad->save()) {
                foreach ($localidad->getMessages() as $message) {
                    $this->flash->message('problema',$message);
                }
                $this->db->rollback();
                return $this->redireccionar('persona/new');

            }
            /*Fin: Agregar localidad*/
            $persona->setPersonaLocalidadid($localidad->getLocalidadId());
            $persona->setPersonaTelefono($this->request->getPost("persona_telefono",array('int')));
            $persona->setPersonaCelular($this->request->getPost("persona_celular",array('int')));
            $persona->setPersonaEmail($this->request->getPost("persona_email",'email'));
            $persona->setPersonaEstadocivilid($this->request->getPost("persona_estadoCivilId",'int'));
            $persona->setPersonaHabilitado(1);
            $persona->setPersonaFechacreacion(Date('Y-m-d'));

            if (!$persona->save()) {
                foreach ($persona->getMessages() as $message) {
                    $this->flash->message('problema',$message);
                }
                $formulario->clear(array('provincia_id','ciudad_id'));
                $this->db->rollback();
                return $this->redireccionar('persona/new');

            }

            $this->flash->success("Los Datos Personales han sido cargados correctamente");
            $this->db->commit();
            return $this->redireccionar('experiencia/new/'.$curriculum->getCurriculumId());

        } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
            $this->flash->message('problema','Transaccion Fallida: ', $e->getMessage());
        } catch (\Exception $e) {
            $this->flash->message('problema','Transaccion Fallida2: ', $e->getMessage());
        }
    }

    /**
     * Saves a persona edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "curriculum",
                "action" => "login"
            ));
        }

        $persona_id = $this->request->getPost("persona_id");

        $persona =  Curriculum\Persona::findFirstBypersona_id($persona_id);
        if (!$persona) {
            $this->flash->error("La persona no existe - " . $persona_id);

            return $this->dispatcher->forward(array(
                "controller" => "persona",
                "action" => "index"
            ));
        }
        if ($this->security->checkToken()) {

            $persona->setPersonaApellido($this->request->getPost("persona_apellido"));
            $persona->setPersonaNombre($this->request->getPost("persona_nombre"));
            $persona->setPersonaFechanacimiento($this->request->getPost("persona_fechaNacimiento"));
            $persona->setPersonaTipodocumentoid($this->request->getPost("persona_tipoDocumentoId"));
            //$persona->setPersonaNumerodocumento($this->request->getPost("persona_numeroDocumento"));
            $persona->setPersonaSexo($this->request->getPost("persona_sexo"));
            $persona->setPersonaNacionalidadid($this->request->getPost("persona_nacionalidadId"));
            /*Actualizar localidad*/
            $localidad = \Curriculum\Localidad::findFirstByLocalidadId($persona->getPersonaLocalidadid());
            $localidad->setLocalidadCodigopostal($this->request->getPost('localidad_codigoPostal', 'int'));
            $localidad->setLocalidadDomicilio($this->request->getPost('localidad_domicilio', 'string'));
            $localidad->setLocalidadCiudadid($this->request->getPost('ciudad_id', 'int'));
            $this->db->begin();
            if (!$localidad->update()) {
                foreach ($localidad->getMessages() as $message) {
                    $this->flash->message('problema', $message);
                }
                $this->db->rollback();
                return $this->redireccionar('persona/edit/' . $persona_id);
            }
            /*Fin: Actualizar localidad*/
            $persona->setPersonaLocalidadid($localidad->getLocalidadId());
            $persona->setPersonaTelefono($this->request->getPost("persona_telefono"));
            $persona->setPersonaCelular($this->request->getPost("persona_celular"));
            //$persona->setPersonaEmail($this->request->getPost("persona_email"));
            $persona->setPersonaEstadocivilid($this->request->getPost("persona_estadoCivilId"));

            if (!$persona->update()) {

                foreach ($persona->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->db->rollback();
                return $this->redireccionar('persona/edit/' . $persona_id);
            }
            $curriculum = Curriculum\Curriculum::findFirstByCurriculum_id($persona->getPersonaCurriculumid());
            $curriculum->setCurriculumUltimamodificacion(date('Y-m-d'));
            if (!$curriculum->update()) {

                foreach ($curriculum->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->db->rollback();
                return $this->redireccionar('persona/edit/' . $persona_id);
            }
            $this->db->commit();
            $this->flash->notice("Los Datos Personales se han actualizado correctamente");
            $this->view->form = new DatosPersonalesForm($persona, array('edit' => true));//Reenviar el formulario al view
           //return $this->redireccionar('curriculum/ver/' . $persona->getPersonaCurriculumid());
            $this->response->redirect('curriculum/ver/'. $persona->getPersonaCurriculumid());
        }
    }

    /**
     * Deletes a persona
     *
     * @param string $persona_id
     */
    public function deleteAction($persona_id)
    {

        $persona = Curriculum\Persona::findFirstBypersona_id($persona_id);
        if (!$persona) {
            $this->flash->error("Los Datos Personales no fueron encontrados");

            return $this->dispatcher->forward(array(
                "controller" => "persona",
                "action" => "index"
            ));
        }

        if (!$persona->delete()) {

            foreach ($persona->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "persona",
                "action" => "search"
            ));
        }

        $this->flash->success("La persona ha sido eliminada.");

        return $this->dispatcher->forward(array(
            "controller" => "persona",
            "action" => "index"
        ));
    }

}
