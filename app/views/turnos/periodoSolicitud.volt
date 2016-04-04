<section id="onepage" class="admin bg-rayado">

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
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="">Período de Solicitud de Turnos</h2>
                {{ link_to('administrar/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
                <p><i class="fa fa-info-circle"
                      style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                    <em>Llene los campos para generar un nuevo período para solicitar turnos.</em>
                </p>
            </div>
        </div>

        <div class="row  form-blanco borde-top borde-left-4 borde-right-4">
            <div class="" align="center">
                <h3 style="text-transform: uppercase">{{ content() }}</h3>
            </div>

            <div class="col-md-12">
                    {{ form('turnos/guardarPeriodoSolicitud','method':'post','style':'text-align:left') }}

                    <div class="row">
                        <div align="center">
                            <h4><ins><strong>Período para solicitud de turnos </strong></ins></h4><br>

                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            {{ formulario.label('fechasTurnos_inicioSolicitud',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_inicioSolicitud',['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_inicioSolicitud') }}
                        </div>
                        <div class="col-md-4">
                            {{ formulario.label('fechasTurnos_finSolicitud',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_finSolicitud',['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_finSolicitud') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            {{ formulario.label('fechasTurnos_diaAtencion',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_diaAtencion',['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_diaAtencion') }}
                        </div>
                        <div class="col-md-4">
                            {{ formulario.label('fechasTurnos_diaAtencionFinal',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_diaAtencionFinal',['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_diaAtencionFinal') }}
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            {{ formulario.label('fechasTurnos_cantidadDeTurnos',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_cantidadDeTurnos' ,['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_cantidadDeTurnos') }}
                        </div>
                        <div class="col-md-4">
                            {{ formulario.label('fechasTurnos_cantidadDiasConfirmacion',['class': 'control-label']) }}
                            {{ formulario.render('fechasTurnos_cantidadDiasConfirmacion',['class': 'form-control']) }}
                            {{ formulario.messages('fechasTurnos_cantidadDiasConfirmacion') }}
                        </div>

                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-lg-9 col-lg-offset-4">
                            {{ submit_button('GUARDAR','class':'btn btn-blue btn-lg form-control','style':'width:320px;') }}
                        </div>
                    </div>
                    {{ end_form() }}

                </div>
        </div>
    </div>
</section>
