
<section id="certificacion">

    <style>
        .heading h2 {font-size: 30px;line-height: 35px;}
    </style>

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

                <!-- CONTENT -->
                <div class="about_content wow bounceInUp ">

                    {{ form('turnos/guardarDatosEdicion', 'method': 'post') }}

                    <div class="row">

                            {#id#}
                            {{hidden_field("idSolicitud", "value":idSolicitud)}}

                            {#estado#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="estado">Estado:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ select("estado",'value':estado,lista,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>

                            {#monto max#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="montoM">Monto m&aacute;ximo:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ text_field("montoM",'value':montoM,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>

                            {#monto posible#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="montoP">Monto posible:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ text_field("montoP",'value':montoP,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>

                            {#cant cuotas#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="cantCuotas">Cantidad de cuotas:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ text_field("cantCuotas",'value':cantCuotas,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>

                            {#valor cuotas#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="valorCuota">Valor de la cuota:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ text_field("valorCuota",'value':valorCuota,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>

                            {#observaciones#}
                            <div class="col-lg-3  col-md-3  col-sm-6 col-xs-12 pull-left">
                                <label for="obs">Observaciones:</label>
                            </div>
                            <div class="col-lg-5  col-md-5  col-sm-6 col-xs-12" >
                                {{ text_area("obs",'value':obs,'class':'btn-lg btn-block') }}
                            </div>
                            <br/><br/><br/><br/><br/>
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



















