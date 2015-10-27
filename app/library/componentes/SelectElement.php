<?php
/**
 * SelectElement es un elemento HTML identico al SELECT con la excepcion que se genera en una
 * sola linea para que pueda ser renderizado en javascript. Por lo general se utiliza en
 * Modales.
 * User: dmunioz
 * Date: 26/10/2015
 * Time: 13:46
 */

class SelectElement extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct( $name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    public function render($attributes = null)
    {
        //$html='<select id="miSelect" name="miSelect"><option value="pendiente">PENDIENTE</option><option value="revision">REVISION</option><option value="denegado">DENEGADO</option></select>';
        $html = "<select id=\"" . $this->getName() ."\" name=\"" . $this->getName() . "\">";
        foreach($this->getAttributes () as $option => $valor)
        {
            $html .= "<option value=\"" . $option. "\">$valor";
            $html .= "</option>";
        }
        $html .="</select>";
        return $html;
    }
}