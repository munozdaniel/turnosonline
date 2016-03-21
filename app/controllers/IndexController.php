<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {

        parent::initialize();

    }

    /**
     * Cada vez que ingrese a la pagina,  verificara si el campo revisado de la tabla scheduled esta en 0 y verificara
     * el estado de las fecha start y la fecha end :
     * - Si el dia actual es menor a la fecha start => Informar en la seccion services que los turnos comenzaran a partir de la fecha start.
     * - Si el dia actual se encuentra entre start y end =>
     * - si el dia actual supera a la fecha end => se buscaran todos los turnos que no fueron confirmados (solicitudTurno_respuestaChequeada)
     * y se los seteara a 2 para que sean cancelados.
     */
    public function indexAction()
    {
        $this->tag->setTitle('Bienvenidos');
        $this->view->setTemplateAfter('main');
        $this->assets->collection('headerCss')
            ->addCss('css/slick.css')
            ->addCss('css/superslides.css');
        $this->assets->collection('footer')
            ->addJs('js/menu.js')
            ->addJs('js/jquery.superslides.min.js')
            ->addJs('js/slick.min.js')
            ->addJs('js/jquery.ui.map.js')
            ->addJs('https://maps.googleapis.com/maps/api/js',false)
            ->addJs('js/customIndex.js')
            ->addJs('js/redireccionarSeccion.js');
        /*  $this->assets->collection('footerInline')
               ->addInlineJs("if(self.location=='http://192.168.42.149/impsweb/'){var timeoutId = setTimeout(\"self.location='#about'\",15000);}");
        */
        $schedule = $this->getDi()->get('schedule');
        $puntoProgramado = $schedule->getByType('plazo')->getLast();
        //MENSAJES PREDETERMINADOS:
        $this->view->mensajePeriodo = ' <a class=""><div class="service_iconarea"><span class="fa fa-ticket service_icon" style="background-color:rosybrown !important;"></span></div>
                                            <h3 class="service_title" style="color:rosybrown;">Turnos Online</h3> </a>'.
                                            '<p style="color:rosybrown;"><strong>El período para solicitar turnos no se encuentran habilitado por el momento.</strong>
                                            Las fechas se dispondrán a través de la pagina web y en nuestras oficinas.
                                            Por cualquier consulta puede escribirnos <a href="#contact" style="color: #1E90FF"> aquí </a>
                                            o llamarnos al (0299) 4479921</p> <br/><br/>';

        $this->view->mensajeSlider = '<h2 class="borde-bottom" style="font-size: 24px;line-height: 40px;"> EL PERIODO PARA SOLICITAR TURNOS ONLINE NO SE ENCUENTRA HABILITADO POR EL MOMENTO </h2>
                        <p> Por cualquier consulta puede llamarnos al (0299) 4479921</p> <a href="#service"> </a> ';

        if (!empty($puntoProgramado)) {

            $date = date_create($puntoProgramado->getStart());
            $dateFin = date_create($puntoProgramado->getEnd());

            //Si el periodo  no esta habilitado todavia
            if ($puntoProgramado->isBefore())
            {
                $this->view->mensajePeriodo = ' <a class=""><div class="service_iconarea"><span class="fa fa-ticket service_icon" style="background-color: #CDD3D4 !important;"></span></div>
                                            <h3 class="service_title">Turnos Online</h3></a>' .
                    '<p> <strong>El período para solicitar turnos no se encuentran habilitado por el momento.</strong>
                                                Los turnos se podrán retirar a partir del : <strong>' . date_format($date, 'd/m/Y H:i:s') . '</strong><br>
                                                Por cualquier consulta puede escribirnos <a href="#contact" style="color: #1E90FF"> aquí </a>
                                                o llamarnos al (0299) 4479921<br><br>
                                            </p>';
                $this->view->mensajeSlider = '<h2 class="borde-bottom" style="font-size: 24px;line-height: 40px;"> EN EL PERIODO <br> ' . date_format($date, 'd/m/Y') . ' AL ' . date_format($dateFin, 'd/m/Y') . ' SE PODRÁN SOLICITAR TURNOS ONLINE  </h2>
                        <p></p> <a href="#service"> </a> ';
            }

            //Si el periodo se encuentra
            if ($puntoProgramado->isActive())
            {
                $this->view->mensajePeriodo = '' . $this->tag->linkTo(array("turnos/index", '<div class="service_iconarea"><span class="fa fa-ticket service_icon"></span></div><h3 class="service_title">Turnos Online <br> '. date_format($date, 'd/m/Y').' al '. date_format($dateFin, 'd/m/Y') .' </h3>', "class" => "")) .
                    '<p><strong> SOLICITUD DE TURNOS HABILITADOS  </strong><br>Para adquirir los Préstamos Personales es necesario que solicite un turno con anticipación. En caso de no poseer un correo electrónico se puede acercar a las oficinas de IMPS para solicitarlo manualmente.  </p><p>Por cualquier consulta puede escribirnos <a href="#contact" style="color: #1E90FF"> aquí </a>
                                                o llamarnos al (0299) 4479921</p>';

                $this->view->mensajeSlider = '<h2 class="borde-bottom" style="font-size: 24px;line-height: 40px;"> PERIODO HABILITADO PARA SOLICITAR TURNOS ONLINE <br> ' . date_format($date, 'd/m/Y') . ' AL ' . date_format($dateFin, 'd/m/Y') . '  </h2>
                        <p></p>' . $this->tag->linkTo(array("turnos/index", 'Solicitar Turno', "class" => "slider_btn slow"));
            }
            //Si el periodo para solicitar turnos ya termino.
            if ($puntoProgramado->isAfter()) {

                $ultimoPeriodo = Fechasturnos::findFirstByFechasTurnos_activo(1);
                if (!empty($ultimoPeriodo)) {
                    $solicitudes = Solicitudturno::findBySolicitudTurno_respuestaChequeada(0);
                    foreach ($solicitudes as $unaSolicitud) {
                        $unaSolicitud->solicitudTurno_respuestaChequeada = 2;//Se los cancela porque se les vencieron el plazo.
                        $unaSolicitud->save();
                    }
                    $ultimoPeriodo->fechasTurnos_activo = 0;
                    if (!$ultimoPeriodo->save()) {
                        $this->flash->error("LOS PERIODOS PARA LA SOLICITUD DE TURNOS NO SE HAN DESHABILITADOS. ");
                    }
                }

            }
        }

    }

    /**
     * Ejemplo de como utilizar mpdf y crear un pdf a partir de otro pdf
     * (generando un link hacia el archivo es mas que suficiente para mostrar el pdf)
     */
    public function crearPdfOrdenanzaAction()
    {
        $this->tag->setTitle('PDF');
        $this->view->setTemplateAfter('main');
        $this->buscarPdf('files/prestaciones/Ordenanza_11633.pdf');
    }

    private function buscarPdf($url)
    {
        $this->tag->setTitle('BUSCAR PDF');
        $this->view->setTemplateAfter('main');
        $mpdf = new mPDF();
        $mpdf->SetImportUse();
        $pagecount = $mpdf->SetSourceFile($url);
        for ($i = 1; $i <= $pagecount; $i++) {
            // Do not add page until page template set, as it is inserted at the start of each page (? guat)
            $mpdf->AddPage();
            $tplId = $mpdf->ImportPage($i);
            $mpdf->UseTemplate($tplId, '', '', 210, 297);
        }
        $mpdf->WriteHTML('<p><indexentry content="Dromedary" xref="Camel:types" />The dromedary is atype of camel</p>');
        // The template $tplId will be inserted on all subsequent pages until (optionally)
        // $mpdf->SetPageTemplate();
        $mpdf->Output();
        exit;
    }

    public function emailContactoAction()
    {
        $this->tag->setTitle('CONTACTO');
        $this->view->setTemplateAfter('main');
        if ($this->request->isPost()) {
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Host = 'mail.imps.org.ar';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'consultas@imps.org.ar';
            $this->mail->Password = 'consul';
            $this->mail->SMTPSecure = '';
            $this->mail->Port = 26;

            $this->mail->addAddress('consultas@imps.org.ar');


            //Datos del Usuario Origen.
            $this->mail->From = $this->request->getPost('email');
            $this->mail->FromName = $this->request->getPost('nombre');
            $this->mail->Subject = 'Mensaje enviado por la página web de IMPS.';
            $texto = '<p style="color: #6C7A89; font-family:Arial;"> De: ' . $this->request->getPost('nombre') . '<br/><br/>Email: ' . $this->request->getPost('email') . '<br/><br/>Asunto: ' . $this->request->getPost('asunto') . '<br/><br/>Mensaje:   ' . $this->request->getPost('mensaje') . '</p>';
            $this->mail->Body = 'El siguiente mensaje  fue enviado por la página web de IMPS: <br/>' . $texto;


            if ($this->mail->send()) {
                $this->flash->success("Gracias por contactarse con nosotros, en breve le daremos una respuesta.");
            } else
                $this->flash->success("Ha sucedido un error. No es posible comunicarse con nuestras oficinas momentáneamente..");

            $this->redireccionar('index/index');
        }
    }
    public function revistaAction(){
        $this->tag->setTitle('Revista IMPS');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footer')
            ->addJs('plugins/turnjs/extras/jquery-ui-1.8.20.custom.min.js')
            ->addJs('plugins/turnjs/extras/modernizr.2.5.3.min.js')
            ->addJs('plugins/turnjs/lib/hash.js')
            ->addJs('plugins/turnjs/magazine/conf-slider.js');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

    }

}

