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
            ->addCss('plugins/vegas/vegas.css');
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $this->assets->collection('footer')
            ->addJs('js/slick.min.js')
            ->addJs('js/jquery.ui.map.js')
            ->addJs('https://maps.googleapis.com/maps/api/js', false)
            ->addJs('js/customIndex.js')
            ->addJs('js/afterload.js')
            ->addJs('plugins/vegas/vegas.min.js');
        $this->assets->collection('footerInline')
            ->addInlineJs("

                    $('#inicio-slider').vegas({
                      overlay: true,
                      transition: 'fade',
                      transitionDuration: 4000,
                      delay: 10000,
                      color: '#375a7f',
                      animation: 'random',
                      animationDuration: 20000,
                      slides: [
                        { src: '/impsweb/public/img/inicio/01_ini.jpg' },
                        { src: '/impsweb/public/img/inicio/02_ini.jpg' },
                        { src: '/impsweb/public/img/inicio/03_ini.jpg' },
                        { src: '/impsweb/public/img/inicio/07_ini.jpg' }
                      ],
                      overlay: '/impsweb/public/plugins/vegas/overlays/04.png'
                    });
               ");
    }
    /**
     * Verifica en que estado se encuentra el periodo para solicitar turnos y genera los botones.
     */
    public function controlarEstadoTurnosAjaxAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success']=false;
        $retorno['mensaje']="";
        $retorno['boton']="<a class='list-group-item'><h4> <i class='fa fa-ban'></i> Solicitar Turno</h4>
                                <p><strong>El período para solicitar turnos no se encuentran habilitado por el momento.</strong></p>
                           </a>";
        $aVerTurno = $this->tag->linkTo(
            array('solicitudTurno/buscarTurno',
                '<h4> <i class="fa fa-ticket"></i>  Ver información de Turno</h4>
                                                <p>Si usted desea puede cancelar su asistencia o imprimir el comprobante de turno. </p>', 'class' => 'list-group-item'));

        //Existe un periodo?.
        $periodo= Fechasturnos::findFirst(array('fechasTurnos_activo=1'));
        if(!$periodo)
        {
            echo json_encode($retorno);
            return;
        }
        //Tiene turnos disponibles?
        if($periodo->getFechasturnosSinturnos()==0)
        {
            $retorno['boton']="<a class='list-group-item  borde-3-rojo fondo-rojo'>
                                <h4> <i class='fa fa-ban'></i> Solicitar Turno</h4>
                                <p><strong>Lamentablemente no hay turnos disponibles</strong></p>
                           </a>";
            echo json_encode($retorno);
            return;
        }
        //Está habilitado el periodo para solicitar turnos?.
        if(!$periodo->esPlazoParaSolicitarTurno())
        {
            $aSolicitarTurno="<a class='list-group-item '>
                                <h4> <i class='fa fa-ban'></i> Solicitar Turno</h4>
                                <p><strong>El plazo para solicitar turnos ha finalizado</strong></p>
                           </a>";
             $retorno['boton'] = $aSolicitarTurno . " " . $aVerTurno;
            echo json_encode($retorno);
            return;
        }
        $aSolicitarTurno = $this->tag->linkTo(array('solicitudTurno/index', '<h4> <i class="fa fa-check-circle"></i> Solicitar Turno</h4>
                                                <p>Periodo habilitado para solicitar turnos</p>', 'class' => 'list-group-item borde-3-verde'));
           $retorno['boton'] = $aSolicitarTurno . " " . $aVerTurno;
        $retorno['success']=true;

        echo json_encode($retorno);
        return;

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
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

    }

    public function revistaAction()
    {
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js')
        ->addJs('plugins/turnjs/extras/jquery-ui-1.8.20.custom.min.js');
        if (!$this->request->isGet()) {
            return $this->redireccionar('index/catalogo');
        }
        $volumen = $this->request->get('volumen', 'int');
        $dir = "./img/revista/volumen/$volumen";
        if (is_dir($dir)) {
            $this->view->volumen = $volumen;
            $this->tag->setTitle('Revista IMPS');
            $this->assets->collection('footer')
                //->addJs('plugins/turnjs/extras/jquery-ui-1.8.20.custom.min.js')
                ->addJs('plugins/turnjs/extras/modernizr.2.5.3.min.js')
                ->addJs('plugins/turnjs/lib/hash.js')
                ->addJs('plugins/turnjs/magazine/conf-slider.js');
        } else {
            $this->flash->error("La revista seleccionada no se encuentra disponible por el momento");
            return $this->redireccionar('index/catalogo');
        }
    }


    public function emprendimientoAction()
    {
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $this->tag->setTitle('Emprendimiento IMPS');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");

    }

    /**
     * Explica como funciona el sistema de turnos.
     */
    public function presentacionTurnosAction()
    {
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $this->tag->setTitle('Información Turnos Online');
        $this->view->setTemplateAfter('admin');
        $this->assets->collection('headerCss')
            ->addCss("css/individual.css");
        $this->assets->collection('footerInline')->addInlineJs("$(\".navbar-fixed-top\").addClass('past-main');");
    }

    /**
     *
     */
    public function guiaAction()
    {
        $this->assets->collection('jquery')
            ->addJs('js/jquery.min.js');
        $this->tag->setTitle('Guía de Trámites');
        $this->view->setTemplateAfter('admin');
    }

}

