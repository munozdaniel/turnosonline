<section id="certificacion">

    <style>
        .heading h2 {font-size: 30px;line-height: 35px;}
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Edicion de un periodo</h2>
                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row formulario-turnos">

            <div class="col-md-12">
                {{ content() }}
            </div>

            <div class="col-lg-8 col-md-8 col-md-offset-2">

                {{ link_to('turnos/deshabilitar/'~idPeriodo,'DESHABILITAR PERIODO','class':'btn btn-danger btn-large pull-right') }}
                <div class="about_content wow bounceInUp ">
                    {{ form('turnos/guardarDatosEdicionPeriodo','method':'post','style':'text-align:left') }}

                    <div class="row">

                        {{ hidden_field('idPeriodo','value':idPeriodo) }}

                        <h4><label>Per&iacute;odo para solicitud de turnos </label></h4><br>

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
                        <h4><label>Dia de atenci&oacute;n de turnos </label></h4><br>

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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{ submit_button('GUARDAR','class':'btn btn-blue btn-lg btn-block') }}
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>