<?php
/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 28/12/2015
 * Time: 8:57
 */

class DataListScript  extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct( $name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    public function render($attributes = null)
    {
        $url = $this->getAttributes ()['url'];
        $idPrincipal = $this->getAttributes ()['idPrincipal'];
        $idSecundario = $this->getAttributes ()['idSecundario'];
        $columnas = $this->getAttributes ()['columnas'];

        $html="";
        $html .= " <script> \n";
        $html .= " $(\"#$idPrincipal\").change(function (event) { \n";
        $html .= " var value = $(this).val(); \n";
        $html .= " var getResultsUrl = 'buscarCiudades'; \n";
        $html .= " $.ajax({ \n";
        $html .= " data: {\"id\": value}, \n";
        $html .= " method: \"POST\", \n";
        $html .= " url: '$url', \n";
        $html .= " success: function (response) { \n";
        $html .= " $(\"#$idSecundario\").empty(); \n";
        $html .= " parsed = $.parseJSON(response); \n";
        $html .= " var html = \"\"; \n";
        $html .= " for(datos in parsed.lista) \n";
        $html .= " { \n";
        $html .= " html += '<option value=\"'+parsed.lista[datos]['".$columnas[0]."']+'\">'+ \n";
        $html .= " parsed.lista[datos]['".$columnas[1]."']+'</option>'; \n";
        $html .= " } \n";
        $html .= " $('select#$idSecundario').html(html); \n";
        $html .= " console.log(response); \n";
        $html .= " }, \n";
        $html .= " error: function (error) { \n";
        $html .= " alert(\"ERROR : \"+error.statusText) ; \n";
        $html .= " console.log(error); \n";
        $html .= " } \n";
        $html .= " }); \n";
        $html .= " }); \n";
        $html .= " </script> \n";
        return $html;
    }
}