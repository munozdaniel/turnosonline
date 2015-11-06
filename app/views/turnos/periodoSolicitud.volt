<section id="certificacion">

    {#Firefox: Para ver el calendario en los input type=date #}
    {{ javascript_include('js/firefox/polyfiller.js') }}
    <script>
        webshims.setOptions('forms-ext', {types: 'date'});
        webshims.polyfill('forms forms-ext');
    </script>


    <style>
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>

    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Período de Solicitud de Turnos</h2>

                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                        <p><i class="fa fa-info-circle"
                              style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                            <em>Llene los campos para generar un nuevo período para solicitar turnos.</em>
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

                <div class="about_content wow bounceInUp ">
                    {{ form('turnos/guardarPeriodoSolicitud','method':'post','style':'text-align:left') }}

                    <div class="row">
                        <h4><label>Período para solicitud de turnos </label></h4><br>

                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
                            {{ formulario.label('periodoSolicitudDesde',['class': 'control-label']) }}
                            {{ formulario.render('periodoSolicitudDesde',['class': 'btn-block']) }}
                            {{ formulario.messages('periodoSolicitudDesde') }}
                        </div>
                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
                            {{ formulario.label('periodoSolicitudHasta',['class': 'control-label']) }}
                            {{ formulario.render('periodoSolicitudHasta',['class': 'btn-block']) }}
                            {{ formulario.messages('periodoSolicitudHasta') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h4><label>Día de atención de turnos </label></h4><br>

                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
                            {{ formulario.render('periodoAtencionDesde',['class': 'btn-block']) }}
                            {{ formulario.messages('periodoAtencionDesde') }}
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <h4>{{ formulario.label('cantidadDias',['class': 'control-label']) }}</h4><br>
                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
                            {{ formulario.render('cantidadDias',['class': 'btn-block']) }}
                            {{ formulario.messages('cantidadDias') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h4>{{ formulario.label('cantidadTurnos',['class': 'control-label']) }}</h4><br>
                        <div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-12 col-xs-12">
                            {{ formulario.render('cantidadTurnos' ,['class': 'btn-block']) }}
                            {{ formulario.messages('cantidadTurnos') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-9 col-lg-offset-2">
                            {{ submit_button('GUARDAR','class':'btn btn-blue btn-lg btn-block') }}
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- cdn for modernizr, if you haven't included it already -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>