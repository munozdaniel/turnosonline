<!--=========== BEGAIN PRICING SECTION ================-->
<section id="onepage" class="admin bg-rayado">
    <div class="container">


        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="">Sistema de Turnos Online</small>
                </h2>
                {{ link_to('index/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
            </div>
        </div>
        <div align="center"><h1> {{ content() }}</h1></div>
        {% if admin or empleado or supervisor %}
        <div class="row  form-blanco borde-top borde-left-4 borde-right-4">


                <div class="col-sm-4">
                    {{ link_to('turnos/turnosSolicitados',
                    '<div class="panel mini-box">
                            <span class="box-icon bg-azul-pl">
                                <i class="fa fa-list-alt "></i>
                            </span>
                        <div class="box-info">
                            <p class="size-h2"><strong>Listado</strong></p>
                            <p class="text-muted">Turnos Solicitados</p>
                        </div>
                    </div>') }}
                </div>
                <div class="col-sm-4">
                    {{ link_to('turnos/turnosRespondidos','
                    <div class="panel mini-box">
                            <span class="box-icon bg-green-pl">
                                <i class="fa fa-paper-plane-o"></i>
                            </span>

                        <div class="box-info">
                            <p class="size-h2"><strong>Listado</strong></p>

                            <p class="text-muted">Respuestas Enviadas</p>
                        </div>
                    </div>') }}
                </div>
            <div class="col-sm-4">
                {{ link_to('turnos/turnosCancelados','
                    <div class="panel mini-box">
                            <span class="box-icon bg-red-pl">
                                <i class="fa fa-ticket"></i>
                            </span>

                        <div class="box-info">
                            <p class="size-h2"><strong>Listado</strong></p>

                            <p class="text-muted">Turnos Cancelados</p>
                        </div>
                    </div>') }}
            </div>
                <div class="col-sm-4">
                    {{ link_to('turnos/solicitudManual','
                    <div class="panel mini-box">
                            <span class="box-icon bg-red-pl">
                                <i class="fa fa-ticket"></i>
                            </span>

                        <div class="box-info">
                            <p class="size-h2"><strong>Solicitud Manual</strong></p>

                            <p class="text-muted">Turno</p>
                        </div>
                    </div>') }}
                </div>

            {% endif %}
            {% if admin or supervisor %}
            <div class="col-sm-4">
                {{ link_to('turnos/periodoSolicitud','
                <div class="panel mini-box">
                        <span class="box-icon bg-yellow-pl">
                            <i class="fa fa-calendar"></i>
                        </span>

                    <div class="box-info">
                        <p class="size-h2"><strong>Crear Periodo</strong></p>

                        <p class="text-muted">Atención de Turnos</p>
                    </div>
                </div>') }}
            </div>
            <div class="col-sm-4">
                {{ link_to('turnos/verPeriodos','
                <div class="panel mini-box">
                        <span class="box-icon bg-sky-pl">
                            <i class="fa fa-bars"></i>
                        </span>

                    <div class="box-info">
                        <p class="size-h2"><strong>Historial</strong></p>

                        <p class="text-muted">Periodos</p>
                    </div>
                </div>') }}
            </div>
        </div>
        {% endif %}


            {% if admin or rrhh %}
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="">Gestión de Curriculum</small>
                </h2>
                {{ link_to('index/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
            </div>
        </div>
        <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4">
            <div class="col-sm-4">
                {{ link_to('turnos/turnosSolicitados',
                '<div class="panel mini-box">
                                <span class="box-icon bg-azul-pl">
                                    <i class="fa fa-list-alt"></i>
                                </span>
                            <div class="box-info">
                                <p class="size-h2">Listado</p>
                                <p class="text-muted">Turnos Solicitados</p>
                            </div>
                        </div>') }}
            </div>
        </div>
            {% endif %}

    </div>
</section>
<!--=========== END PRICING SECTION ================-->
