<?php

class SesionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Iniciar Sesión');
        parent::initialize();
    }

    public function indexAction()
    {
    }

    /**
     *  Se encarga de validar el usuario y el password con la base de datos.
     */
    public function validarAction()
    {
        if($this->request->isPost())
        {
            try
            {
                //Obtengo los datos ingresado en el form.
                $nombre  = $this->request->getPost('sesion_nombre','string');
                $pass   = $this->request->getPost('sesion_contrasena','alphanum');

                //Busco el usuario en la bd a partir de los datos ingresados.
                $usuarios =  Usuarios::findFirst(array(
                    "(usuario_nick = :usuario_nick:) AND (usuario_contrasenia = :usuario_contrasenia:) AND (usuario_activo = 1)",
                    'bind' => array('usuario_nick' => $nombre, 'usuario_contrasenia' => base64_encode($pass))
                ));

                if($usuarios!=false)
                {
                    if($this->_registrarSesion($usuarios))
                    {
                        $miSesion = $this->session->get('auth');
                        $this->flash->message('exito', "Bienvenido/a " . $miSesion['usuario_nombreCompleto'] . " - Rol: " . $miSesion['rol_nombre']);
                        //Redireccionar la ejecución si el usuario es valido
                        return $this->redireccionar('administrar/index');
                    }
                    else
                    {
                        $this->flash->message('aviso',"<p>EL USUARIO NO TIENE LOS ROLES NECESARIOS PARA ADMINISTRAR</p>");
                        return $this->redireccionar('sesion/index');
                    }
                }
                else
                {
                    $this->flash->message('problema',"<p>No se encontro el Usuario, verifique contraseña/nick</p>");
                }
            }
            catch(\Phalcon\Annotations\Exception $ex)
            {
                $this->flash->error($ex->getMessage());
            }

        }
        return $this->redireccionar('sesion/index');
    }

    private function _registrarSesion($usuario)
    {
        $idRol = Usuarioporrol::findFirst(array(
            "usuario_id     =       :usuario:",
            'bind'          =>      array('usuario'=>$usuario->usuario_id)
        ));

        if(!$idRol)//No se encontro el rol asignado al usuario
           return false;
        else
        {
            $rol = Rol::findFirstByRolId($idRol->rol_id);

            $this->session->set('auth',array('usuario_id'   =>  $usuario->usuario_id,
                'usuario_nombreCompleto'  =>  $usuario->usuario_nombreCompleto,
                'usuario_nick'  =>  $usuario->usuario_nick,
                'rol_nombre'   =>  $rol->rol_nombre));
            return true;
        }
    }
    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function cerrarAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Se ha cerrado la sesión.');
        return $this->redireccionar("index/index");
    }
    /**
     * Busca con el email del empleado los datos usuario y contraseña, y los envia al correo ingresado por formulario.
     */
    public function recuperarAction()
    {   $this->view->pick('sesion/index');
        if($this->request->isPost())
        {
            $email  = $this->request->getPost('sesion_email');
            $usuario = Usuarios::findFirstByUsuario_email($email);
            if($usuario)
            {
                $this->mail->CharSet        = 'UTF-8' ;
                $this->mail->Host           = 'mail.imps.org.ar';
                $this->mail->SMTPAuth       = true;
                $this->mail->Username       = 'desarrollo@imps.org.ar';
                $this->mail->Password       = 'sis$%&--temas';
                $this->mail->SMTPSecure     = '';
                $this->mail->Port           = 26;
                $this->mail->addAddress($email);


                $this->mail->From  = "desarrollo@imps.org.ar";
                $this->mail->FromName   =  "Soporte Tecnico";
                //$this->mail->addReplyTo("munozda87@hotmail.com", "user");
                $this->mail->Subject        =   "Recuperar Contraseña";
                $mensaje = "Se ha solicitado la contraseña y el usuario para acceder al <em>Sistema Web IMPS</em>. <br>En caso de que usted no lo haya solicitado, por favor borre este email y comuniquese con <em>Soporte Tecnico IMPS</em> via email: <b>desarrollo@imps.org.ar</b>.<br><br> <b>USUARIO</b>:   ".$usuario->usuario_nick."<br> <b>CONTRASEÑA</b>:". base64_decode($usuario->usuario_contrasenia);
                $this->mail->Body           =   $mensaje;
                if($this->mail->send())
                    $this->flash->message('exito',"<p>Su solicitud fue procesada con éxito. En minutos recibirá un mail con su nueva
contraseña.</p>");
                else
                    $this->flash->message('problema',"<p>Ha sucedido un error. No es posible comunicarse con nuestras oficinas momentáneamente.</p>");

                $this->redireccionar('sesion/index');
            }
            else{
                $this->flash->message('problema',"<p>No se encuentra registrado ningún usuario con el correo: $email</p>");
            }
        }
    }
}

