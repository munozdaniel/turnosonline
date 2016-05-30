<section id="onepage" class="admin bg_line">
    <div class="container ">

        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>LISTA DE PERÍODOS</ins>
                    {{ link_to("administrar/index", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary','style':'margin-left:55%;background-color:#195889;') }}
                    <br>
                </h1>

                <h3>
                    <small style="color:white;">
                        <em>A continuación se visualizarán todos los períodos creados hasta la fecha.</em>
                        <br/>
                        <em style="color:tomato">
                        <ins>Advertencia:</ins>
                        La modificación del periodo activo queda bajo responsabilidad del usuario.
                        </em>
                    </small>
                </h3>

            </div>

            <br/>
            {{ content() }}

            <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4">

                <table class="table table-striped table-bordered table-condensed" style="text-align: center !important;">
                    <thead>
                        <tr>
                            <th style="text-align: center !important;">Dia inicial para solicitud</th>
                            <th style="text-align: center !important;">Dia final para solicitud</th>
                            <th style="text-align: center !important;">Día inicial para atención</th>
                            <th style="text-align: center !important;">Día final para atención</th>
                            <th style="text-align: center !important;">Cantidad de turnos</th>
                            <th style="text-align: center !important;">Cantidad de turnos autorizados</th>
                            <th style="text-align: center !important;">Periodo activo</th>
                            <th style="text-align: center !important;"><i class="glyphicon glyphicon-edit"></i></th>
                            <th style="text-align: center !important;">Listado de solicitudes</th>

                        </tr>
                    </thead>

                    <tbody>
                        {% for item in tabla.items %}
                            {% if   item.fechasTurnos_activo == 0 %}
                                <tr>
                            {% else %}
                                <tr style="background-color: rgba(154, 205, 50, 0.28); font-style: italic; font-weight: bold">
                            {% endif %}
                            <td>
                                {% set fechaModif =  date('d/m/Y',(item.fechasTurnos_inicioSolicitud) | strtotime) %}
                                {{ fechaModif }}
                            </td>
                            <td>
                                {% set fechaModif =  date('d/m/Y',(item.fechasTurnos_finSolicitud) | strtotime) %}
                                {{ fechaModif }}
                            </td>
                            <td>
                                {% set fechaModif =  date('d/m/Y',(item.fechasTurnos_diaAtencion) | strtotime) %}
                                {{ fechaModif }}
                            </td>
                            <td>
                                {% set fechaModif =  date('d/m/Y',(item.fechasTurnos_diaAtencionFinal) | strtotime) %}
                                {{ fechaModif }}
                            </td>
                            <td>{{ item.fechasTurnos_cantidadDeTurnos }}</td>
                            <td>{{ item.fechasTurnos_cantidadAutorizados }}</td>

                            {% if   item.fechasTurnos_activo == 0 %}
                                <td>NO</td>
                                <td>-</td>
                                <td>
                                    {{ link_to("turnos/solicitudesPorPeriodo/?idP="~item.fechasTurnos_id,'LISTA','class':'btn btn-success') }}
                                </td>
                            {% else %}
                                <td>SI</td>
                                <td width="7%">
                                    {{ link_to("turnos/editarPeriodo/"~item.fechasTurnos_id,'<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-danger") }}
                                </td>
                                <td>-</td>
                            {% endif %}

                            </tr>
                        {% endfor %}
                    </tbody>

                    <tbody>
                        <tr>
                            <td colspan="10">
                                <div align="center">
                                    {{ link_to('turnos/verPeriodos','<i class="icon-fast-backward"></i> Primera','class':'btn') }}
                                    {{ link_to('turnos/verPeriodos?page='~tabla.before,'<i class="icon-step-backward"></i> Anterior','class':'btn') }}
                                    {{ link_to('turnos/verPeriodos?page='~tabla.next,'<i class="icon-step-forward"></i> Siguiente','class':'btn') }}
                                    {{ link_to('turnos/verPeriodos?page='~tabla.last,'<i class="icon-fast-forward"></i> Última','class':'btn') }}
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                    P&aacute;gina {{ tabla.current }} de {{ tabla.total_pages }}
                                </div>
                            </td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
