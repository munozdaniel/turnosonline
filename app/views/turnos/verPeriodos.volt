<!--=========== BEGAIN TURNO EXITOSO SECTION ================-->
<section id="onepage">
    <div class="container">
        <div class="row col-lg-12 col-md-12">
            <!-- START ABOUT HEADING -->
            <div class="heading">
                <h2 class="wow fadeInLeftBig btn ">LISTA DE PERIODOS</h2>

                <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>

                <p style="font-size: 20px">
                    A continuación se visualizarán todos los períodos creados hasta la fecha.
                    <br><em style="color:tomato">
                        <ins>Advertencia:</ins>
                        La modificación de los periodos queda bajo la responsabilidad del usuario.</em>
                </p>

            </div>
            <div class="about_content">

                <div class="page-header" align="center">
                    {{ content() }}
                </div>
                <table class="table table-striped table-bordered table-condensed"
                       style="text-align: center !important;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Inicio de Solicitud</th>
                        <th>Fin de Solicitud</th>
                        <th>Día de Atención</th>
                        <th>Cantidad de Turnos</th>
                        <th>Cantidad de Autorizados</th>
                        <th>Total de días de confirmación</th>
                        <th>Activo</th>
                        <th style="text-align: center !important;"><i class="glyphicon glyphicon-edit"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in tabla.items %}
                        {% if   item.fechasTurnos_activo == 0 %}
                            <tr>
                        {% else %}
                            <tr style="background-color: rgba(154, 205, 50, 0.28); font-style: italic; font-weight: bold">
                        {% endif %}
                            <td>{{ item.fechasTurnos_id }}</td>
                            <td>{{ item.fechasTurnos_inicioSolicitud }}</td>
                            <td>{{ item.fechasTurnos_finSolicitud }}</td>
                            <td>{{ item.fechasTurnos_diaAtencion }}</td>
                            <td>{{ item.fechasTurnos_cantidadDeTurnos }}</td>
                            <td>{{ item.fechasTurnos_cantidadAutorizados }}</td>
                            <td>{{ item.fechasTurnos_cantidadDiasConfirmacion }}</td>
                            {% if   item.fechasTurnos_activo == 0 %}
                                <td>NO</td>
                            {% else %}
                                <td>SI</td>
                                <td width="7%">
                                    {{ link_to("turnos/editarPeriodo/" ~ item.fechasTurnos_id, '<i class="glyphicon glyphicon-edit"></i> Editar', "class": "btn btn-danger") }}
                                </td>
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
                                <div><p> Pagina {{ tabla.current }} de {{ tabla.total_pages }}</p></div>
                            </div>
                        </td>
                    <tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</section>
<!--=========== END TURNO EXITOSO SECTION ================-->
