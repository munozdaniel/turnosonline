<section id="certificacion">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Edicion de una solicitud</h2>
                        <div class="pull-right">{{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row edicion">
            <div class="col-md-12">
                {{ content() }}
            </div>

            <div class="col-lg-8 col-md-8 col-md-offset-2">

                <!-- START PERIODO SOLICITUD CONTENT -->
                <div class="about_content wow bounceInUp ">

                    {{ form('turnos/guardarDatosEdicion', 'method': 'post') }}

                    <div class="row" >

                            {{hidden_field("idSolicitud", "value":idSolicitud)}}

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="estado">Estado</label>
                                {{ select("estado",'id':'idEstado','value':'pendiente',{'autorizado':'autorizado','denegado':'denegado','pendiente':'pendiente','revision':'revision','denegado por falta de turnos':'denegado por falta de turnos'},'class':'btn-lg btn-block') }} <br/>
                                <br/>
                            </div>

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="montoM">Monto maximo</label>
                                {{ text_field("montoM",'value':0,'class':'btn-lg btn-block') }}<br/>
                                <br/>
                            </div>

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="montoP">Monto posible</label>
                                {{ text_field("montoP",'value':0,'class':'btn-lg btn-block') }}<br/>
                                <br/>
                            </div>

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="cantCuotas">Cantidad de cuotas</label>
                                {{ text_field("cantCuotas",'value':0,'class':'btn-lg btn-block') }}<br/>
                                <br/>
                            </div>

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="valorCuota">Valor de la cuota</label>
                                {{ text_field("valorCuota",'value':0,'class':'btn-lg btn-block') }}<br/>
                                <br/>
                            </div>

                            <div class="col-lg-5 col-lg-offset-3">
                                <label for="obs">Observaciones</label>
                                {{ text_field("obs",'value':'-','class':'btn-lg btn-block') }}<br/>
                                <br/>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-lg-offset-4">
                            {{ submit_button('GUARDAR','class':'btn btn-blue btn-lg btn-block') }}
                        </div>
                    </div>

                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>



















