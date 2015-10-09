<?php
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Acl\Resource;
class Seguridad extends \Phalcon\Mvc\User\Plugin
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        if(!$auth)
            $role = 'INVITADO';
        else
            $role = $auth["rol_nombre"];

        //nombre del controlador al que intentamos acceder
        $controller = $dispatcher->getControllerName();

        //nombre de la acción a la que intentamos acceder
        $action = $dispatcher->getActionName();

        //obtenemos la Lista de Control de Acceso(acl) que hemos creado
        $acl = $this->getAcl();

        //boolean(true | false) si tenemos permisos devuelve true en otro caso false
        $allowed = $acl->isAllowed($role, $controller, $action);

        //si el usuario no tiene acceso a la zona que intenta acceder
        //le mostramos el contenido de la función index del controlador index
        //con un mensaje flash
        if ($allowed != \Phalcon\Acl::ALLOW)
        {
            $this->flash->message('problema',"<p>ZONA RESTRINGIDA, NO TIENES PERMISO PARA ACCEDER A LA SECCIÓN SOLICITADA</p>");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            );
            return false;
        }
    }

    /**
     * lógica para crear una aplicación con roles de usuarios
     */
    public function getAcl()
    {
        if (!isset($this->persistent->acl))
        {
            //creamos la instancia de acl para crear los roles
            $acl = new Phalcon\Acl\Adapter\Memory();

            //por defecto la acción será denegar el acceso a cualquier zona
            $acl->setDefaultAction(Phalcon\Acl::DENY);
            //----------------------------ROLES-----------------------------------

            //registramos los roles que deseamos tener en nuestra aplicación****
            $listaRoles = Rol::find();
            foreach($listaRoles as $rol)
            {
                $acl->addRole(new \Phalcon\Acl\Role($rol->rol_nombre));

                //Recupero todas las paginas de cada rol
                $query = $this->modelsManager->createQuery("SELECT pagina.* FROM acceso,pagina,rol WHERE rol.rol_id=".$rol->rol_id." and rol.rol_id=acceso.rol_id and acceso.pagina_id=pagina.pagina_id");
                $listaPaginasPorRol = $query->execute();
                foreach($listaPaginasPorRol as $pagina)
                {
                    //Recupero todas las acciones de cada pagina
                    $query = $this->modelsManager->createQuery("SELECT pagina.pagina_nombreAccion FROM pagina WHERE pagina.pagina_nombreControlador='".$pagina->pagina_nombreControlador."'");
                    $arregloAcciones= $query->execute();
                    $recursos = array();
                    foreach($arregloAcciones as $accion)
                    {
                        $recursos[] = $accion->pagina_nombreAccion;//convierto las acciones en un arreglo para pasar por parametro al addResource.
                    }
                    $acl->addResource(new Resource($pagina->pagina_nombreControlador),$recursos);
                    foreach($arregloAcciones as $accion)
                    {
                        $acl->allow($rol->rol_nombre,$pagina->pagina_nombreControlador,$accion['pagina_nombreAccion']);//No se puede dar permisos (allow) antes de agregar el recurso (addResource)
                    }
                }
            }
            //El acl queda almacenado en sesión
            $this->persistent->acl = $acl;

        }

        return $this->persistent->acl;
    }

}