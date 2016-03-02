<section id="onepage" class="admin bg-rayado">
    <style>

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
                {% if (cantidadDeTurnos == cantA) %}
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
            <div class="col-sm-6">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="cuadrado-azul"><i class="fa fa-bookmark"></i></div>
                            <strong>TURNOS ONLINE CON RESPUESTAS</strong>
                        </td>
                        <td>
                            <div class="cuadrado-rojo"><i class="fa fa-bookmark"></i></div>
                            <strong>TURNOS ONLINE SIN RESPUESTA</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="cuadrado-verde"><i class="fa fa-bookmark"></i></div>
                            <strong>TURNOS PERSONALES</strong>
                        </td>
                        <td>
                            <div class="cuadrado-amarillo"><i class="fa fa-bookmark"></i></div>
                            <strong>TURNOS MANUALES</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-md-12">
                {{ content() }}
            </div>

            <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
                <table id="tabla" class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="th-titulo">Nº Turno</th>
                        <th class="th-titulo">Legajo</th>
                        <th class="th-titulo">Apellido y nombre</th>
                        <th class="th-titulo">Estado</th>
                        <th class="th-titulo">Fecha respuesta enviada</th>
                        <th class="th-titulo">Usuario</th>
                        <th class="th-titulo">Respuesta chequeada</th>
                        <th class="th-titulo">Imprimir Comprobante</th>
                    </tr>
                    </thead>

                    <tbody>
                    {% for item in page.items %}
                        {# Controlo el color de las filas: PERSONAL - ONLINE CHEQUEADO - ONLINE NO CHEQUEADO#}
                        {% if item['solicitudTurno_tipo']==0 %}{#Online#}
                            {% if  item['solicitudTurno_respChequedaTexto']  == "SI" %}
                                <tr style="background-color: rgba(126, 191, 227, 0.1)">{#azul#}
                            {% else %}
                                {% if  item['solicitudTurno_respChequedaTexto']  == "SI (Turno Cancelado)" %}
                                    <tr style="background-color: rgba(227, 100, 84, 0.1)">{#red#}
                                {% else %}
                                    <tr style="background-color: rgba(227, 100, 84, 0.1)">{#red#}
                                {% endif %}
                            {% endif %}
                        {% elseif  item['solicitudTurno_tipo']==1 %}{#Manual#}
                            <tr style="background-color: rgba(255, 211, 95, 0.1)">{#amarillo#}
                        {% else %}{#Personal#}
                            <tr style="background-color: rgba(19, 143, 44, 0.1)">{#verde#}
                        {% endif %}
                            <td class="td-posicion">{{ item['solicitudTurno_numero'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_legajo'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_nomApe'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_estado'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_fechaRespuestaEnviadaDate'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_nickUsuario'] }}</td>
                            <td class="td-posicion">{{ item['solicitudTurno_respChequedaTexto'] }}</td>
                            {# Controlo la celda Comprobante: Si es Personal o Manual, Si es Online Chequeado o No Chequeado. #}
                            {% if item['solicitudTurno_tipo']==0 %}{#Online#}
                                {% if  item['solicitudTurno_respChequedaTexto']  == "SI" %}
                                    <td class="td-posicion bg-azul-pl">
                                        {{ link_to('turnos/comprobanteTurno/?id='~ item['solicitudTurno_idCodificado'] ,'<i class="fa fa-print pull-left"></i> ONLINE ','class':'btn btn-info btn-block','target':'_blank') }}
                                    </td>
                                {% else %}
                                    {% if  item['solicitudTurno_respChequedaTexto']  == "SI (Turno Cancelado)" %}
                                        <td class="td-posicion bg-red-pl">  CANCELADO</td>
                                    {% else %}
                                        <td class="td-posicion bg-red-pl">  EN ESPERA</td>
                                    {% endif %}
                                {% endif %}
                            {% elseif  item['solicitudTurno_tipo']==1 %}{#Manual#}
                                <td class="td-posicion bg-yellow-pl">
                                    {{ link_to('turnos/comprobanteTurno/?id='~ item['solicitudTurno_idCodificado'] ,'<i class="fa fa-print pull-left"></i> MANUAL ','class':'btn btn-warning btn-block','target':'_blank') }}
                                </td>
                            {% else %}{#Personal#}
                                <td class="td-posicion bg-green-pl">
                                    {{ link_to('turnos/comprobanteTurno/?id='~ item['solicitudTurno_idCodificado'] ,'<i class="fa fa-print pull-left"></i> PERSONAL ','class':'btn btn-success  btn-block','target':'_blank') }}
                                </td>
                            {% endif %}
                        </tr>
                    {% endfor %}
                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="12">
                            <div align="center">
                                {{ link_to("/turnos/turnosRespondidos/?page=1",'Primera','class':'btn btn-gris') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.before,' Anterior','class':'btn btn-gris') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.next,'Siguiente','class':'btn btn-gris') }}
                                {{ link_to("/turnos/turnosRespondidos/?page="~page.last,'Última','class':'btn btn-gris') }}
                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                <strong>P&aacute;gina {{ page.current }} de {{ page.total_pages }}</strong>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div align="center"
                 style="width:25%;position:fixed;bottom:0;border-top:#2AA0C7 2px;left:0;background-color:#2AA0C7; padding: 4px 0 0 0;"
                 class="col-md-4 col-md-offset-5">
                {{ link_to('turnos/listadoEnPdf','VER LISTADO EN PDF','class':'btn btn-blue btn-lg btn-block','target':'_blank') }}
            </div>
        </div>
    </div>
</section>


<script>
    var myVar = setInterval(function () {
        myTimer()
    }, 9000);

    function myTimer() {
        $('#solicitudes').load(' #tabla');
    }

</script>






