<!--=========== BEGAIN PRICING SECTION ================-->
<section id="pricing" class="admin">
    <div class="container">
        <div class="row col-lg-12 col-md-12">
            <!-- START ABOUT HEADING -->
            <div class="heading">
                <h2 class="wow fadeInLeftBig">Panel de Control</h2>
                <p></p>
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
                                                <div>Supervisor</div>
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
                                    <div class="panel-heading" style="    border-color: #5cb85c;
    color: #fff;
    background-color: #5cb85c;">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                {{ link_to('turnos/turnosRespondidos','<i class="fa fa-paper-plane-o fa-5x"></i>','class':'font-blanco') }}
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Supervisor</div>
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
                                            <span class="pull-left">Seleccionar Periodo para solicitud y atencion de turnos</span><br><br>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>') }}

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- =================== GESTION DE USUARIOS ======================-->
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>Gestión de Usuarios</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-child fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Administrador</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">Agregar Rol</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-magic fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Administrador</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">Agregar Permisos</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-list-ul fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Administrador</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">Listar Usuario</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red  wow fadeInUp">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-trash-o fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">Rol</div>
                                                <div>Administrador</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">Eliminar Permisos</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========== END PRICING SECTION ================-->
