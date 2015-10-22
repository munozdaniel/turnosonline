<section id="sesion">
    <div class="container">
        <div class="row">

            <div class="col-sm-6 col-md-4 col-md-offset-4">

                <div class="account-wall" style="margin-top: 25%">

                    <div class="media testi_media">

                        <div class="media-body">
                            <h4 class="media-heading" style="color:#FFFFFF;">INICIAR SESIÓN</h4>
                            <span>Empleados IMPS</span>

                        </div>
                    </div>
                    <hr style="opacity: 0.2">
                    <div class="col-md-12">
                    {{ content() }}
                    </div>
                    {{ form('sesion/validar',"class":"form-signin wow flipInX",'data-wow-duration':'2s','data-wow-delay':'1s') }}
                        {{ text_field('sesion_nombre',"class":"form-control","placeholder":"Usuario",'required':'',"autofocus":"") }}
                        {{ password_field('sesion_contrasena',"class":"form-control","placeholder":"Contraseña",'required':'') }}
                        {{ submit_button('Ingresar','class':'btn btn-lg btn-primary btn-block') }}
                        {{ link_to('index/index','<i class="fa fa-home "></i> Salir','class':'btn btn-lg btn-primary btn-block') }}

                        <a href="#recuperar" data-toggle="modal" class="pull-right need-help"
                           style="color: #FFFFFF; text-decoration: none;">
                            ¿Olvidó su contraseña?
                        </a>

                        <span class="clearfix"></span>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= MODALES =========================== -->
    <!--=========== RecuperarContraseña ================-->
    <div id="recuperar" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-envelope-o"></i> RECUPERAR CONTRASEÑA</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                            <div class="col-lg-12 col-md-12 fuente-16">
                                <!-- START SUBSCRIBE HEADING -->
                                <div class="heading">
                                    <h2 class="wow fadeInLeftBig">Olvidaste tu contraseña o tu usuario? </h2>
                                    <p>La contraseña de inicio de sesión evita el acceso no autorizado al Sistema IMPS. Si no recuerda su contraseña de inicio de sesión, ingrese
                                    su dirección de correo provista por el equipo de desarrollo, y automáticamente se le enviarán los datos a su casilla de mensajes.</p>
                                </div>
                                <!--  FORM -->
                                {{ form('sesion/recuperar',"class":"subscribe_form") }}
                                    <div class="subscrive_group wow fadeInUp">
                                        {{ email_field('sesion_email','class':'form-control subscribe_mail','placeholder':'INGRESE SU CORREO ELECTRONICO') }}
                                        {{ submit_button('class':'subscr_btn btn-theme','value':'Solicitar') }}
                                    </div>
                                {{ end_form() }}
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-green btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--=========== FIN:RecuperarContraseña ================-->
</section>