<section id="certificacion">

    <meta http-equiv="refresh" content="20">

    <style>
        a {color: #2da2c8}
        .heading h2 {font-size: 30px;line-height: 35px;}
    </style>

    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Listado de Solicitudes de Turnos con respuesta enviada</h2>
                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>

                    <div class="fuente-16"> <strong><ins>Periodo de solicitud de turnos</ins>: </strong>{{ fechaI }} - {{ fechaF }}
                    </div>
                    <div class="fuente-16"> <strong><ins>Dia de atenci&oacute;n</ins>: </strong> {{ diaA }}
                    </div>
                    <br/>

                    {% if (cantidadDeTurnos == cantA) %}
                        <div class="fuente-16" style="color:red;">
                            <strong><ins>Total de turnos :</ins> </strong> {{ cantidadDeTurnos }}
                        </div>
                        <div class="fuente-16" style="color:red;">
                            <strong><ins>Turnos autorizados :</ins> </strong> {{ cantA }}
                        </div>
                    {% else %}
                        <div class="fuente-16">
                            <strong><ins>Total de turnos :</ins> </strong> {{ cantidadDeTurnos }}
                        </div>
                        <div class="fuente-16">
                            <strong><ins>Turnos autorizados :</ins> </strong> {{ cantA }}
                        </div>
                    {% endif %}
                    <br/>

                </div>
            </div>
        </div>

        <div class="row edicion">
            <div class="col-md-12">
                {{ content() }}
            </div>
            <div class="col-lg-12 col-md-12">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th style="text-align: center;color:#2da2c8">Nº Turno</th>
                        <th style="text-align: center;color:#2da2c8">Legajo</th>
                        <th style="text-align: center;color:#2da2c8">Apellido y nombre</th>
                        <th style="text-align: center;color:#2da2c8">Estado</th>
                        <th style="text-align: center;color:#2da2c8">Fecha respuesta enviada</th>
                        <th style="text-align: center;color:#2da2c8">Usuario</th>
                        <th style="text-align: center;color:#2da2c8">Respuesta chequeada</th>
                    </tr>
                    </thead>

                    <tbody>
                    {% for item in page.items %}
                        <tr>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_numero'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_legajo'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nomApe'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_estado'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_fechaRespuestaEnviadaDate'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nickUsuario'] }}</td>
                            <td style="text-align: center;width: 180px">{{ item['solicitudTurno_respChequedaTexto'] }}</td>
                        </tr>
                    {% endfor %}
                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="12">
                            <div align="center">
                                {{ link_to("/turnos/turnosRespondidos/?page=1",'Primera','class':'btn') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.before,' Anterior','class':'btn') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.next,'Siguiente','class':'btn') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.last,'Última','class':'btn') }}
                                <div><p> P&aacute;gina {{ page.current }} de {{ page.total_pages }}</p></div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
            {{ link_to('turnos/listadoEnPdf','<div class="col-lg-6 col-lg-offset-3">
                                                <div class="btn btn-blue btn-lg btn-block">
                                                     VER LISTADO EN PDF</div></div>','target':'_blank') }}
            </div>
        </div>
    </div>
</section>










