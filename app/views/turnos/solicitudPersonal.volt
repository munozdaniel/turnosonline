<section id="onepage" class="admin bg-rayado">

    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="wow fadeInLeftBig">Solicitud de Turno para Préstamos</h2>
                {{ link_to('administrar/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
                <p>
                    <i class="fa fa-info-circle"
                       style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                    <em>Por favor, llene los siguientes campos para ingresar una solicitud de turno.</em> <br/><br/>
                </p>
            </div>
        </div>
        {% if informacion is defined %}
            <div class="row form-blanco borde-top borde-left-4 borde-right-4">
                <div class="col-sm-6" align="center">
                    <h3><strong><ins>PERIODO DE SOLICITUD DE TURNOS</ins> </strong>
                        <br>
                    </h3>
                    <h4>
                    Desde {{ informacion['fechaInicio']}} hasta {{ informacion['fechaFinal']}}
                    </h4>
                </div>
                <div class="col-sm-6" align="center">
                    <h3>
                    <strong><ins>DÍA DE ATENCI&Oacute;N</ins></strong>
                        <br>
                    </h3>
                    <h4>
                    {{ informacion['diaAtencion'] }}
                    </h4>
                </div>
            </div>
        {% endif %}
        <div class="row form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4">
            <div align="center">
                <h1> {{ content() }}</h1>
            </div>
            {{ form('turnos/guardarSolicitudPersonal','method':'post','style':'','class':'') }}
            <div class="container">

                <div class="row row-centered">
                    <div class="col-xs-6 col-centered col-fixed">
                        <div class="item">
                            <div class="content">
                                <label class="control-label" for="solicitudTurno_legajo"><small style="color:red">*</small>LEGAJO</label>
                                <input type="number" class="form-control" id="solicitudTurno_legajo" name="solicitudTurno_legajo"
                                       placeholder="INGRESE SU LEGAJO" required="" autocomplete="off">
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-centered">
                    <div class="col-xs-6 col-centered col-fixed">
                        <div class="item">
                            <div class="content">
                                <label class="control-label" for="solicitudTurno_documento"><small style="color:red">*</small>NRO DOCUMENTO</label>
                                <input type="number" class="form-control sin_spinner" id="solicitudTurno_documento" name="solicitudTurno_documento"
                                       placeholder="INGRESE SU DOCUMENTO" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-centered marginBottom-20">
                    <div class="col-xs-6 col-centered col-fixed">
                        <div class="item">
                            <div class="content">
                                <hr>
                                {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{ end_form() }}
        </div>
    </div>

    {{ end_form() }}
    </div>
    </div>
</section>

