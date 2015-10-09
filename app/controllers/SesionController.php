<?php

class SesionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Iniciar Sesión');
        parent::initialize();

    }

    /**
     *
     */
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
                    $this->_registrarSesion($usuarios);
                    $miSesion = $this->session->get('auth');
                    $this->flash->success('Bienvenido/a '.$miSesion['usuario_nombreCompleto'] . " - Rol: ".$miSesion['rol_nombre']);
                    //Redireccionar la ejecución si el usuario es valido
                    return $this->redireccionar('index/index');

                }
                else{
                    $this->flash->error("No se encontro el Usuario, verifique contraseña/nick");
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
        if(empty($idRol))
        {//No se encontro el rol asignado al usuario
            $this->flash->error("Usuario sin Permisos");
            return $this->redireccionar('index/index');
        }
        else
        {
            $rol = Rol::findFirstByRolId($idRol->rol_id);
            $this->session->set('auth',array('usuario_id'   =>  $usuario->usuario_id,
                'usuario_nombreCompleto'  =>  $usuario->usuario_nombreCompleto,
                'usuario_nick'  =>  $usuario->usuario_nick,
                'rol_nombre'   =>  $rol->rol_nombre));
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
    {

    }
}

