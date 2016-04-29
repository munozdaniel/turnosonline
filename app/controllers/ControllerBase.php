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

    protected function importarFechaFirefox()
    {

        $this->assets->collection('footer')
            ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js', false)
            ->addJs('http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js', false);
        $this->assets->collection('footerInline')
            ->addInlineJs("webshims.setOptions('waitReady', false);
                            webshims.setOptions('forms-ext', {types: 'date'});
                            webshims.polyfill('forms forms-ext');");
    }

    /**
     * En uso para los remitos
     */
    protected function importarDataTables()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/css/jquery.dataTables.min.css')
            ->addCss('plugins/datatables/css/buttons.dataTables.min.css')
            ->addCss('plugins/datatables/css/select.dataTables.min.css')
            ->addCss('plugins/datatables/css/fixedHeader.dataTables.min.css')
            // ->addCss('plugins/datatables/css/bootstrap.min.css',false)
            ->addCss('plugins/datatables/css/dataTables.bootstrap.min.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/js/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/js/dataTables.buttons.min.js')
            ->addJs('plugins/datatables/js/buttons.colVis.min.js')
            ->addJs('plugins/datatables/js/dataTables.select.min.js')
            //Excel
            ->addJs('plugins/datatables/excel/jszip.min.js')
            ->addJs('plugins/datatables/excel/pdfmake.min.js')
            ->addJs('plugins/datatables/excel/vfs_fonts.js')
            ->addJs('plugins/datatables/excel/buttons.html5.min.js');
            //Fin:Excel


    }
}
