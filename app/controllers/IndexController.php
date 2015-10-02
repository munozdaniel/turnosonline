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
     /*  $this->assets->collection('footerInline')
            ->addInlineJs("if(self.location=='http://192.168.42.149/impsweb/'){var timeoutId = setTimeout(\"self.location='#about'\",15000);}");
     */
     }

}

