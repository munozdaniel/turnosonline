<?php
/**
 * Se crea un checkbox que permita habilitar/deshabilitar otro componente.
 * User: dmunioz
 * Date: 06/01/2016
 * Time: 12:42
 */

class CheckScript extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct( $name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    /**
     * @param null $attributes
     * ['checkbox']: Atributos del checkbox
     * ['js']: Configuracion para javascript.
     * @return string
     */
    public function render($attributes = null)
    {
        $atributos = $this->getAttributes ()['checkbox'];
        $idPrincipal = $this->getAttributes ()['idPrincipal'];
        $idSecundario = $this->getAttributes ()['idSecundario'];
        $columnas = $this->getAttributes ()['columnas'];
        $html = "<input type='checkbox' id=\"" . $this->getName() ."\" name=\"" . $this->getName() ."onclick='habilitarDeshabilitar()'" ;
        foreach($atributos as $option => $valor)
        {
            $html .= " " . $option. "= '$valor'";
        }
        $html .= "\">";
        return $html;
    }

}