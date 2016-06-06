{#Firefox: Para ver el calendario en los input type=date #}
    {{ javascript_include('js/firefox/polyfiller.js') }}
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>

<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>EDITAR PERÍODO</ins>
                    <br>
                </h1>

                <h3>
                    Llene los campos para generar un nuevo período para solicitar turnos.
                    <br><em style="color:tomato">
                        <ins>Advertencia:</ins>
                        La modificación del periodo activo queda bajo responsabilidad del usuario.</em>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("administrar/index", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}

            <div class="row  form-blanco borde-top borde-left-4 borde-right-4">

                <div class="col-md-12">
                    {{ form('turnos/guardarDatosEdicionPeriodo','method':'post','style':'text-align:left') }}
                    <div class="row">
                        <div align="center">
                            <h4>
                                <ins><strong>Período para solicitud de turnos </strong></ins>
                            </h4>
                            <br>
                            {{ formulario.render('fechasTurnos_id') }}


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

                    </div>
                    <hr>

                    <div class="row">
                        <div class="" align="center">
                            {{ submit_button('GUARDAR CAMBIOS','class':'btn btn-blue btn-lg ') }}
                        </div>
                    </div>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>
