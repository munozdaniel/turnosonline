<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('IMPS | ');

    }

    protected function redireccionar($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1],
                'params' => $params
            )
        );
    }
    protected function importarFechaFirefox(){

       $this->assets->collection('footer')
           ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js',false)
            ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js',false);
        $this->assets->collection('footerInline')
            ->addInlineJs("webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');");
    }
}
