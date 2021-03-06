<style>
    .problema,.exito{font-size: 17px;}
</style>


<section id="onepage" class="admin bg_line">
    <div class="container ">

        <div align="center">

            <div class="curriculum-bg-header modal-header" align="left">
                <h1>
                    <ins>CREAR NUEVO PERÍODO </ins>
                    {{ link_to("administrar/index", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary','style':'margin-left:47%;background-color:#195889;') }}
                    <br>
                </h1>

                <h3>
                    <small><em style=" color:#FFF !important;"> A continuación se podrán crear los períodos para solicitud y atención de turnos.</em></small>
                </h3>
            </div>

            <div align="center" style="background-color:indianred;color:white;width:auto;padding:4px;height:auto;position:fixed;top:235px;">
                <p style="font-size:18px;"> Recuerde: los dias inicial y final del periodo para solicitud no se podr&aacute;n modificar.</p>
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
                                <br> <br>

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

                        <br/><hr> <br/>

                        <div class="row">

                            <div align="center">
                                <h4>
                                    <ins><strong>Período para atención de turnos </strong></ins>
                                </h4>
                                <br><br>

                            </div>

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

                        <br/><hr><br>

                        <div class="row">

                            <div align="center">
                                <h4>
                                    <ins><strong>Cantidad de turnos </strong></ins>
                                </h4>
                                <br>

                            </div>

                            <div class="col-md-4 col-md-offset-4">
                                {{ formulario.label('fechasTurnos_cantidadDeTurnos',['class': 'control-label']) }}
                                {{ formulario.render('fechasTurnos_cantidadDeTurnos' ,['class': 'form-control']) }}
                                {{ formulario.messages('fechasTurnos_cantidadDeTurnos') }}
                            </div>

                        </div>

                        <hr> <br/>

                        <div class="row">
                            <div class="col-lg-9 col-lg-offset-4">
                                {{ submit_button('GUARDAR','class':'btn btn-blue btn-lg btn-block','style':'width:360px;') }}
                            </div>
                        </div>
                        {{ end_form() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
