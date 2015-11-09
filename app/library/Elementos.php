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
            echo  $this->tag->linkTo('administrar/index', '<i class="fa fa-sign-in"></i>  INGRESAR');
            echo "</li>";
        }
        else{

            echo "<li>";
            echo  $this->tag->linkTo('administrar/index', '<i class="fa fa-cogs"></i> '."PANEL DE CONTROL");
            echo "</li>";

            echo "<li>";
            echo  $this->tag->linkTo('', '<i class="fa fa-user"></i> '.strtoupper($auth['usuario_nombreCompleto']));
            echo "</li>";

            echo "<li>";
            echo  $this->tag->linkTo('sesion/cerrar', '<i class="fa fa-sign-out"></i>  SALIR');
            echo "</li>";
        }
    }

}
