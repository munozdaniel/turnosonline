<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">

            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>SISTEMA DE TURNOS ONLINE</ins>
                    {{ link_to("sesion/cerrar", "<i class='fa fa-home'></i> SALIR",'class':'btn btn-lg btn-primary','style':'margin-left:42%;background-color:#195889;') }}
                    <br>
                </h1>

            </div>

            <hr>

            {{ content() }}

            {% if admin or empleado or supervisor %}
            <div class="row  form-blanco borde-top borde-left-4 borde-right-4">
                <div class="col-sm-4">
                    {{ link_to('turnos/turnosSolicitados',
                    '<div class="panel mini-box">
                            <span class="box-icon bg-azul-pl">
                                <i class="fa fa-list-alt "></i>
                            </span>
                        <div class="box-info" align="left">
                            <p class="size-h2"><strong>Listado de </strong></p>
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

                        <div class="box-info" align="left">
                            <p class="size-h2"><strong>Listado de</strong></p>

                            <p class="text-muted"> Respuestas Enviadas</p>
                        </div>
                    </div>') }}
                </div>
                <div class="col-sm-4">
                    {{ link_to('turnos/turnosCancelados','
                    <div class="panel mini-box">
                            <span class="box-icon bg-red-pl">
                                <i class="fa fa-ticket"></i>
                            </span>

                        <div class="box-info"  align="left">
                            <p class="size-h2"><strong>Listado de</strong></p>

                            <p class="text-muted"> Turnos Cancelados</p>
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

                    <div class="box-info"  align="left">
                        <p class="size-h2"><strong>Crear Periodo de</strong></p>

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

                    <div class="box-info"  align="left">
                        <p class="size-h2"><strong>Historial</strong></p>

                        <p class="text-muted">de Periodos</p>
                    </div>
                </div>') }}
                </div>
            </div>
            {% endif %}



        </div>
    </div>
</section>
<!--=========== END PRICING SECTION ================-->
