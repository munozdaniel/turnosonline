<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>CREAR NUEVO PERÍODO </ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> Complete los datos</em></small>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("administrar/index", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-md-12">
                        {{ form('turnos/guardarPeriodoSolicitud','method':'post','style':'text-align:left') }}

                        <div class="row">
                            <div align="center">
                                <h4>
                                    <ins><strong>Período para solicitud de turnos </strong></ins>
                                </h4>
                                <br>

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
        </div>
    </div>
</section>
