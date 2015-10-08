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
    /*Ejemplo de como utilizar mpdf y crear un pdf a partir de otro pdf*/
    public function crearPdfOrdenanzaAction(){
        $this->buscarPdf('files/prestaciones/Ordenanza_11633.pdf');
    }
    private function buscarPdf($url)
    {
        $mpdf=new mPDF();
        $mpdf->SetImportUse();
        $pagecount = $mpdf->SetSourceFile($url);
        for($i=1;$i<=$pagecount;$i++){
            // Do not add page until page template set, as it is inserted at the start of each page (? guat)
            $mpdf->AddPage();
            $tplId = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($tplId,'','',210,297);
        }
        $mpdf->WriteHTML('<p><indexentry content="Dromedary" xref="Camel:types" />The dromedary is atype of camel</p>');
        // The template $tplId will be inserted on all subsequent pages until (optionally)
        // $mpdf->SetPageTemplate();
        $mpdf->Output();
        exit;
    }
}

