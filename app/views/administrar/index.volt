<!--=========== BEGAIN PRICING SECTION ================-->
<section id="onepage" class="admin">
    <div class="container">

        {{ content() }} <br/>

        <div class="row col-lg-12 col-md-12">
            <div class="heading">
                <h2>PANEL DE CONTROL</h2>
            </div>
        </div>

        <div class="row col-lg-12 col-md-12">
            <div class="pricing_area">
                <div class="row">
                    <!-- =================== TURNOS ONLINE ======================-->
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>Sistema de Turnos Online</h3></div>
                        <div class="panel-body">

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/turnosSolicitados','<i class="fa fa-list-alt fa-5x"></i>','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Empleado</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ link_to('turnos/turnosSolicitados','<div class="panel-footer">
                                            <span class="pull-left">Listado de turnos solicitados</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green  wow fadeInUp" style="border-color: #5cb85c;">
                                    <div class="panel-heading" style="border-color: #5cb85c;color: #fff;background-color: #5cb85c;">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/turnosRespondidos','<i class="fa fa-paper-plane-o fa-5x"></i>','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Empleado</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ link_to('turnos/turnosRespondidos','<div class="panel-footer">
                                            <span class="pull-left">Listado de turnos solicitados con respuesta enviada</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}
                                </div>
                            </div>
                            {#nuevo 20/10 #}
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow  wow fadeInUp" style="border-color:lightcoral;">
                                    <div class="panel-heading" style="border-color: lightcoral;color: #fff;background-color: lightcoral;">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/solicitudManual','<i class="fa fa-ticket fa-5x"></i>','class':'font-blanco','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Empleado</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ link_to('turnos/solicitudManual','<div class="panel-footer">
                                            <span class="pull-left">Solicitud Manual</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}
                                </div>
                            </div>
                            {# fin new #}
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/periodoSolicitud','<i class="fa fa-calendar fa-5x"></i>','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Supervisor</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ link_to('turnos/periodoSolicitud','<div class="panel-footer">
                                            <span class="pull-left">Crear Periodo para solicitud y atencion de turnos</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}
                                </div>
                            </div>

                            {#nuevo 19/10 #}

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow  wow fadeInUp" style="border-color:#5cb;">
                                    <div class="panel-heading" style="border-color: #5cb;color: #fff;background-color: #5cb;">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/verPeriodos','<i class="fa fa-calendar-check-o fa-5x"></i>','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Supervisor</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ link_to('turnos/verPeriodos','<div class="panel-footer">
                                            <span class="pull-left">Listado con Periodos para solicitud y atención de turnos</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}
                                </div>
                            </div>
                            {# fin new #}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========== END PRICING SECTION ================-->
