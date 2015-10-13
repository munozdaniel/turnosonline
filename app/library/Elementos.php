<?php
class Elementos extends \Phalcon\Mvc\User\Component
{
    private $_menu = array(
        'inicio'     =>  array(
                'class'     =>  'scroll',
                'titulo'    =>'Inicio',
                'controlador'=>'',
                'accion'    =>'#home'
        ),
        'contacto'  =>  array(
                'class'     =>  'scroll',
                'titulo'    =>'Contacto',
                'controlador'=>'contacto',
                'accion'    =>'index'
        )
    );
    private $_sesion = array(

        'login'     =>  array(
            'class'     =>  '',
            'titulo'    =>'Ingresar',
            'controlador'=>'sesion',
            'accion'    =>'index'
        )
    );
    /**
     * Armar el menu de la cabecera
     *
     * @return string
     */
    public function getMenu()
    {

        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_sesion = array(
                'estadisticas'     =>  array(
                    'class'     =>  '',
                    'titulo'    =>'Estadisticas',
                    'controlador'=>'estadistica',
                    'accion'    =>'index'
                )
            );
            $this->_sesion['login']= array(
                'class'     =>  '',
                'titulo'    =>'Salir',
                'controlador'=>'sesion',
                'accion'    =>'cerrar'
            );
        }
        else
        {

        }
        $nombreDelControlador = $this->view->getControllerName();
        foreach($this->_menu as $contenido => $item)
        {
            //if ($nombreDelControlador == $item['controlador'])
              //  $activo = "active";
            //else
              //  $activo ="";
            echo "<li class='".$item['class']." "."'>";
             echo $this->tag->linkTo($item['controlador'] . '/' . $item['accion'], $item['titulo']), '</li>';
            //echo "<a href='".$item['controlador']."".$item['accion']."'>".$item['titulo']."</a></li>";
        }
        foreach($this->_sesion as $contenido => $item)
        {
            echo "<li>";
            echo $this->tag->linkTo($item['controlador'] . '/' . $item['accion'], $item['titulo']), '</li>';
            //echo "<li><a href='".$item['controlador']."/".$item['accion']."'>".$item['titulo']."</a></li>";
        }
    }
}
