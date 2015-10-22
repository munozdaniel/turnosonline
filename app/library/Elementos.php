<?php
class Elementos extends \Phalcon\Mvc\User\Component
{
    /**
     * Si no esta logueado muestra el link "INGRESAR"
     * Si esta logueado muestra el link "SALIR" mas los datos del usuario.
     */
    public function getItemMenu(){
        $auth = $this->session->get('auth');
        if(!$auth){
            echo "<li>";
            echo  $this->tag->linkTo('sesion/index', '<i class="fa fa-sign-in"></i>  Ingresar');
            echo "</li>";
        }
        else{

            echo "<li>";
            echo  $this->tag->linkTo('', 'Usuario: '.$auth['usuario_nombreCompleto']);
            echo "</li>";
            echo "<li>";
            echo  $this->tag->linkTo('', 'Rol: '.$auth['rol_nombre']);
            echo "</li>";
            echo "<li>";
            echo  $this->tag->linkTo('sesion/cerrar', '<i class="fa fa-sign-out"></i>  Salir');
            echo "</li>";
        }
    }

}
