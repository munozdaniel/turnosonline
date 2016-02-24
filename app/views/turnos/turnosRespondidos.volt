<section id="onepage" class="admin bg-rayado">

    <meta http-equiv="refresh" content="20" property="">

    <style>
        a {
            color: #2da2c8
        }

        .heading h2 {
            font-size: 30px;
            line-height: 35px;
        }
    </style>

    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="">Listado de Solicitudes de Turnos <br> con respuesta enviada</h2>
                {{ link_to('administrar/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-undo"></i> VOLVER') }}
            </div>
        </div>
        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-sm-6">
                <div class="fuente-14"><strong>
                        <ins>PERIODO DE SOLICITUD DE TURNOS :</ins>
                    </strong>{{ fechaI }} - {{ fechaF }}
                </div>
                <div class="fuente-14"><strong>
                        <ins>DIA DE ATENCI&Oacute;N :</ins>
                    </strong> {{ diaA }}
                </div>
            </div>
            <div class="col-sm-6">{% if (cantidadDeTurnos == cantA) %}
                    <div class="fuente-14" style="color:red;">
                        <strong>
                            <ins>TOTAL DE TURNOS :</ins>
                        </strong> {{ cantidadDeTurnos }}
                    </div>
                    <div class="fuente-14" id="idCantA" style="color:red;">
                        <strong>
                            <ins>TURNOS AUTORIZADOS :</ins>
                        </strong> <strong id="cantAutorizados">{{ cantA }}</strong>
                    </div>
                {% else %}
                    <div class="fuente-14">
                        <strong>
                            <ins>TOTAL DE TURNOS :</ins>
                        </strong> {{ cantidadDeTurnos }}
                    </div>
                    <div class="fuente-14" id="idCantA">
                        <strong>
                            <ins>TURNOS AUTORIZADOS :</ins>
                        </strong> <strong id="cantAutorizados">{{ cantA }}</strong>
                    </div>
                {% endif %}
            </div>
        </div>

        <div class="row  form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-md-12">
                {{ content() }}
            </div>
            <div class="col-lg-12 col-md-12"> <!-- margin-top:-5%; -->
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
                        <th style="text-align: center;color:#2da2c8">Comprobante</th>
                    </tr>
                    </thead>

                    <tbody>
                    {% for item in page.items %}
                        {% if  item['solicitudTurno_respChequedaTexto']  == "SI" %}
                            <tr class="" style="">
                        {% else %}
                            <tr class="bg-red-pl" style="background: rgb(96,108,136); /* Old browsers */
                                                        background: -moz-linear-gradient(top,  rgba(96,108,136,1) 0%, rgba(63,76,107,1) 100%); /* FF3.6-15 */
                                                        background: -webkit-linear-gradient(top,  rgba(96,108,136,1) 0%,rgba(63,76,107,1) 100%); /* Chrome10-25,Safari5.1-6 */
                                                        background: linear-gradient(to bottom,  rgba(96,108,136,1) 0%,rgba(63,76,107,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                                                        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#606c88', endColorstr='#3f4c6b',GradientType=0 ); /* IE6-9 */
                                                        ">
                        {% endif %}
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_numero'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_legajo'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nomApe'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_estado'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_fechaRespuestaEnviadaDate'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nickUsuario'] }}</td>
                        <td style="text-align: center;width: 180px">{{ item['solicitudTurno_respChequedaTexto'] }}</td>
                        {% if  item['solicitudTurno_respChequedaTexto']  == "SI" %}
                            <td style="text-align: center;width: 180px">{{ link_to('turnos/comprobanteTurno/'~ item['solicitudTurno_id'] ,'GENERAR ','class':'btn btn-info btn-large','target':'_blank') }}</td>
                        {% else %}
                            <td style="text-align: center;width: 180px"> EN ESPERA...</td>
                        {% endif %}
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
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                P&aacute;gina {{ page.current }} de {{ page.total_pages }}
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










