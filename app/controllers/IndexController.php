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
            ->addCss('plugins/vegas/vegas.css')
            ->addCss('css/superslides.css');
        $this->assets->collection('footer')
            ->addJs('js/jquery.min.js')
            //->addJs('js/menu.js')
           // ->addJs('js/jquery.superslides.min.js')
            ->addJs('js/slick.min.js')
            ->addJs('js/jquery.ui.map.js')
            ->addJs('https://maps.googleapis.com/maps/api/js',false)
            ->addJs('js/customIndex.js')
            ->addJs('js/redireccionarSeccion.js')
            ->addJs('plugins/vegas/vegas.min.js')
        ;
          $this->assets->collection('footerInline')
               ->addInlineJs("

                    $('#inicio-slider').vegas({
                      overlay: true,
                      transition: 'fade',
                      transitionDuration: 4000,
                      delay: 10000,
                      color: 'red',
                      animation: 'random',
                      animationDuration: 20000,
                      slides: [
                        { src: '/impsweb/public/img/inicio/1.jpg' },
                        { src: '/impsweb/public/img/inicio/4.jpg' },
                        { src: '/impsweb/public/img/inicio/5.gif' }
                      ],
                      overlay: '/impsweb/public/plugins/vegas/overlays/04.png'
                    });
               ");

        $schedule = $this->getDi()->get('schedule');
        $puntoProgramado = $schedule->getByType('plazo')->getLast();
        //MENSAJES PREDETERMINADOS:
        $this->view->linkTurnoOnline = "<a class='list-group-item  borde-3-rojo fondo-rojo'><h4>Solicitar Turno</h4>
                                <p><strong>El período para solicitar turnos no se encuentran habilitado por el momento.</strong></p>
                           </a>";

        if (!empty($puntoProgramado)) {

            $date = date_create($puntoProgramado->getStart());
            $dateFin = date_create($puntoProgramado->getEnd());

            //Si el periodo  no esta habilitado todavia
            if ($puntoProgramado->isBefore())
            {

                $this->view->linkTurnoOnline = "<a class='list-group-item  borde-3-naranja fondo-naranja'><h4>Solicitar Turno</h4>
                                <p>El período para solicitar turnos no se encuentran habilitado por el momento.</p>
                                <p>Los turnos se podrán solicitar entre :<br> <strong>" . date_format($date, 'd/m/Y') ." - ".date_format($dateFin, 'd/m/Y')  . "</strong></p>
                           </a>";

            }

            //Si el periodo se encuentra
            if ($puntoProgramado->isActive())
            {
                if(Fechasturnos::verificaSiHayTurnosEnPeriodo()['success']) {
                    $aSolicitarTurno = $this->tag->linkTo(array('turnos/index', '<h4>Solicitar Turno</h4>
                                                <p>Periodo habilitado para solicitar turnos</p>', 'class' => 'list-group-item borde-3-verde'));
                }
                else{
                    $aSolicitarTurno = $this->tag->linkTo(array('turnos/index', '<h4><i class="fa fa-ban"></i> Solicitar Turno</h4>
                                                <p>Lamentablemente no hay turnos disponibles</p>', 'style' => 'background-color: #F44336;
    color: #FFF;','class'=>'list-group-item'));
                }
                $aVerTurno =  $this->tag->linkTo(array('turnos/buscarTurno','<h4>Ver Turno</h4>
                                                <p>Si desea puede consultar el código de turno o cancelarlo. Se recuerda que la cancelación debe ser con 48hs de anticipación.</p>','class'=>'list-group-item'));
                $this->view->linkTurnoOnline = $aSolicitarTurno ." ".$aVerTurno ;

                /*$this->view->mensajePeriodo = '' . $this->tag->linkTo(array("turnos/index", '<div class="service_iconarea"><span class="fa fa-ticket service_icon"></span></div><h3 class="service_title">Turnos Online <br> '. date_format($date, 'd/m/Y').' al '. date_format($dateFin, 'd/m/Y') .' </h3>', "class" => "text-decoration-none")) .
                    '<p><strong> SOLICITUD DE TURNOS HABILITADOS  </strong><br>Para adquirir los Préstamos Personales es necesario que solicite un turno con anticipación. En caso de no poseer un correo electrónico se puede acercar a las oficinas de IMPS para solicitarlo manualmente.  </p><p>Por cualquier consulta puede escribirnos <a href="#contact" style="color: #1E90FF"> aquí </a>
                                                o llamarnos al (0299) 4479921</p>';*/

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
                    //$ultimoPeriodo->fechasTurnos_activo = 0; // NO se debe desactivar el periodo. El periodo se desactiva cuando finaliza la fecha de atencion
                    if (!$ultimoPeriodo->save()) {
                        $this->flash->error("LOS PERIODOS PARA LA SOLICITUD DE TURNOS NO SE HAN DESHABILITADOS. ");
                    }
                }

            }
        }

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
    public function catalogoAction()
    {
        $this->tag->setTitle('Catalogo IMPS');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

    }
    public function revistaAction(){
        if(!$this->request->isGet()){
            return $this->redireccionar('index/catalogo');
        }
        $volumen = $this->request->get('volumen','int');
        $dir = "./img/revista/volumen/$volumen";
        if(is_dir($dir)){
            $this->view->volumen = $volumen;
            $this->tag->setTitle('Revista IMPS');
            $this->assets->collection('footer')
                ->addJs('plugins/turnjs/extras/jquery-ui-1.8.20.custom.min.js')
                ->addJs('plugins/turnjs/extras/modernizr.2.5.3.min.js')
                ->addJs('plugins/turnjs/lib/hash.js')
                ->addJs('plugins/turnjs/magazine/conf-slider.js');
        }
        else
        {
            $this->flash->error("La revista seleccionada no se encuentra disponible por el momento");
            return $this->redireccionar('index/catalogo');
        }



    }


    public function emprendimientoAction(){
        $this->tag->setTitle('Emprendimiento IMPS');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

    }
    /**
     * Explica como funciona el sistema de turnos.
     */
    public function presentacionTurnosAction(){
        $this->tag->setTitle('Información Turnos Online');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('headerCss')
            ->addCss("css/individual.css");
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");


    }

}

