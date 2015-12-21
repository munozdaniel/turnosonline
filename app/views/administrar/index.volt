<!--=========== BEGAIN PRICING SECTION ================-->
<section id="onepage" class="admin">
    <div class="container">

        {{ content() }} <br/>

        <div class="row ">
            {% if admin or empleado or supervisor %}

                <div class="heading">
                    <h2>Sistema de Turnos Online</h2>
                </div>
                <div class="col-sm-4">
                    {{ link_to('turnos/turnosSolicitados',
                    '<div class="panel mini-box">
                            <span class="box-icon bg-azul-pl">
                                <i class="fa fa-list-alt "></i>
                            </span>
                        <div class="box-info">
                            <p class="size-h2">Listado</p>
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
                            <p class="size-h2">Listado</p>

                            <p class="text-muted">Respuestas Enviadas</p>
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
                            <p class="size-h2">Turno</p>

                            <p class="text-muted">Solicitud Manual</p>
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
                        <p class="size-h2">Atención de Turnos</p>

                        <p class="text-muted">Crear Periodo</p>
                    </div>
                </div>') }}
            </div>
            <div class="col-sm-4">
                {{ link_to('turnos/verPeriodos','
                <div class="panel mini-box">
                        <span class="box-icon bg-sky-pl">
                            <i class="fa fa-calendar-check-o"></i>
                        </span>

                    <div class="box-info">
                        <p class="size-h2">Historial</p>

                        <p class="text-muted">Periodos</p>
                    </div>
                </div>') }}
            </div>
            {% endif %}
            {% if admin or rrhh %}
            <div class="heading">
                <h2>Curriculum</h2>
            </div>
            <div class="col-sm-4">
                {{ link_to('turnos/turnosSolicitados',
                '<div class="panel mini-box">
                                <span class="box-icon bg-azul-pl">
                                    <i class="fa fa-list-alt "></i>
                                </span>
                            <div class="box-info">
                                <p class="size-h2">Listado</p>
                                <p class="text-muted">Turnos Solicitados</p>
                            </div>
                        </div>') }}
            </div>
            {% endif %}
        </div>

    </div>
</section>
<!--=========== END PRICING SECTION ================-->
