<section id="certificacion">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <!-- START  SOLICITUD TURNOS HEADING -->
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Solicite turnos para préstamos personales</h2>
                        <div class="pull-right">{{ link_to('index/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                        <br>
                        <p><i class="fa fa-info-circle"
                              style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                            <em>Por favor, llene los siguientes campos para solicitar un turno con el departamento de Préstamos .</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row formulario-turnos">
            <div class="col-md-12">
                {{ content() }}
            </div>

            <div class="col-lg-8 col-md-8 col-md-offset-2">

                <!-- START SOLICITUD TURNOS CONTENT -->
                <div class="about_content wow bounceInUp ">
                    {{ form('turnos/guardarSolicitudTurno','method':'post','style':'text-align:left') }}
                    {% for elto in formulario %}
                        <div class="row">
                            <span>{{ elto.label(['class': 'control-label']) }}</span>
                            {{ elto }}
                            {{ formulario.messages(elto.getName()) }}
                        </div>
                    {% endfor %}
                    {{ submit_button('ENVIAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>