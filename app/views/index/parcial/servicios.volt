<!--=========== BEGIN SERVICE SECTION ================-->
<section id="service">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- BEGAIN SERVICE HEADING -->
                <div class="heading">
                    <h2 class="wow fadeInLeftBig">Servicios Online</h2>
                    <p>Desde la comodidad de tu casa podrás usar nuestros servicios. </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- BEGAIN SERVICE  -->
                <div class="service_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <!-- BEGAIN SINGLE SERVICE -->
                            <div class="single_service wow fadeInLeft">
                                {{ link_to('certificacion/index','<div class="service_iconarea">
                                    <span class="fa fa-file-text service_icon"></span>
                                </div>
                                <h3 class="service_title">Certificación Negativa</h3>
                                ','class':'puntero') }}
                                <p> Ud. podrá obtener el comprobante de Certificación Negativa que acredita que no registra antecedentes de Jubilación y/o Pensión del Instituto Municipal de Previsión Social de la Ciudad de Neuquén.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <!-- BEGAIN SINGLE SERVICE -->
                            <div class="single_service wow fadeInRight">
                                <a class="">
                                    <div class="service_iconarea">
                                        <span class="fa fa-ticket service_icon" style="background-color: #CDD3D4 !important;"></span>
                                    </div>
                                    <h3 class="service_title">Turnos Online</h3>
                                </a>
                                <p>
                                    <strong>Los Período para la Solicitud de Turnos no se encuentran habilitado por el momento</strong>.
                                    Las fechas se dispondrán a través de la pagina web y en nuestras oficinas.
                                    Por cualquier consulta puede escribirnos <a href="#contact" style="color: #1E90FF"> aquí </a>
                                    o llamarnos al (0299) 4479921<br><br>
                                </p>
                                {#
                                {{ link_to('turnos/index','class':'puntero',' <div class="service_iconarea">
                                    <span class="fa fa-ticket service_icon"></span>
                                </div>
                                <h3 class="service_title">Turnos Online</h3>') }}

                                <p>Para adquirir los Préstamos Personales es necesario que solicite un turno con anticipación, las fechas para solicitarlos se publicarán <strong><a style="color:#286090; cursor: pointer !important;">aquí</a></strong>. En caso de no poseer un correo electrónico se puede acercar a las oficinas de IMPS para solicitarlo manualmente.  </p>

                                #}
                            </div>
                        </div>
                        {#
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <!-- BEGAIN SINGLE SERVICE -->
                            <div class="single_service wow fadeInLeft">
                                <div class="service_iconarea">
                                    <span class="fa fa-list-alt service_icon"></span>
                                </div>
                                <h3 class="service_title">Estado de Deuda</h3>
                                <p>Proximamente. El Servicio se encuentra en construcción.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <!-- BEGAIN SINGLE SERVICE -->
                            <div class="single_service wow fadeInRight">
                                <div class="service_iconarea">
                                    <span class="fa fa-users service_icon"></span>
                                </div>
                                <h3 class="service_title">Identificación de Afiliados</h3>
                                <p>Proximamente. El Servicio se encuentra en construcción.</p>
                            </div>
                        </div>
                        #}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========== END SERVICE SECTION ================-->
