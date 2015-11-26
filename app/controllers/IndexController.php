<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Bienvenidos');
        $this->view->setTemplateAfter('main');
        parent::initialize();

    }
    public function indexAction()
    {
        $this->assets->collection('footer')->addJs('js/menu.js');
     /*  $this->assets->collection('footerInline')
            ->addInlineJs("if(self.location=='http://192.168.42.149/impsweb/'){var timeoutId = setTimeout(\"self.location='#about'\",15000);}");
     */
    }

    /**
     * Ejemplo de como utilizar mpdf y crear un pdf a partir de otro pdf
     * (generando un link hacia el archivo es mas que suficiente para mostrar el pdf)
     */
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
    public function emailContactoAction()
    {
        if($this->request->isPost())
        {
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Host = 'mail.imps.org.ar';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'desarrollo@imps.org.ar';
                $this->mail->Password = 'sis$%&--temas';
            $this->mail->SMTPSecure = '';
            $this->mail->Port = 26;

            $this->mail->addAddress('desarrollo@imps.org.ar');


            //Datos del Usuario Origen.
            $this->mail->From = $this->request->getPost('email');
            $this->mail->FromName = $this->request->getPost('nombre');
            $this->mail->Subject = 'Mensaje enviado por la página web de IMPS.';
            $texto = '<p style="color: #6C7A89; font-family:Arial;"> De: '.$this->request->getPost('nombre').'<br/><br/>Email: '.$this->request->getPost('email').'<br/><br/>Asunto: '.$this->request->getPost('asunto').'<br/><br/>Mensaje:   '.$this->request->getPost('mensaje').'</p>';
            $this->mail->Body ='El siguiente mensaje  fue enviado por la página web de IMPS: <br/>'.$texto;


            if ($this->mail->send()) {
                $this->flash->success("Gracias por contactarse con nosotros, en breve le daremos una respuesta.");
            } else
                $this->flash->success("Ha sucedido un error. No es posible comunicarse con nuestras oficinas momentáneamente..");

            $this->redireccionar('index/index');
        }
    }

}

