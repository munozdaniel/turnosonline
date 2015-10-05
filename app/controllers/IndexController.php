<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Bienvenidos');
        parent::initialize();

    }
    public function indexAction()
    {
        $this->assets->collection('footer')
            ->addJs('js/menu.js');
     /*  $this->assets->collection('footerInline')
            ->addInlineJs("if(self.location=='http://192.168.42.149/impsweb/'){var timeoutId = setTimeout(\"self.location='#about'\",15000);}");
     */
     }
    /*Si se van a crear otras vistas tener en cuenta que el menu no se va a visualizar correctamente ya */
}

