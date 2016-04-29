<style>

    .heading h2 {
        font-size: 30px;
        line-height: 35px;
    }

</style>

<section id="onepage" class="admin bg_line">
    <div align="center">
        <div class="curriculum-bg-header modal-header " align="left">
            <h1>
                <ins>LISTA DE TURNOS RESPONDIDOS</ins>
                <br>
            </h1>
            <h3>
                <small><em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos afiliados
                        con turnos Autorizado/Denegado.</em></small>
            </h3>
            <table class="" width="100%">
                <tr>
                    <td align="right">{{ link_to("administrar", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                </tr>
            </table>

        </div>
    </div>
    <hr>
    <div class="row form-blanco borde-top borde-left-4 borde-right-4">
        {% if informacion is defined %}
            <div class="col-sm-3" align="right">
                <h3><strong>
                        <ins>PERIODO DE TURNOS</ins>
                    </strong>
                </h3>
                <h4>
                    Desde {{ informacion['fechaInicio'] }} <br> Hasta {{ informacion['fechaFinal'] }}
                </h4>

            </div>
            <div class="col-sm-3" align="center">
                <h3>
                    <strong>
                        <ins>DÍA DE ATENCI&Oacute;N</ins>
                    </strong>
                </h3>
                <h4>
                    Desde {{ informacion['diaAtencion'] }}
                    <br>Hasta {{ informacion['diaAtencionFinal'] }}
                </h4>
            </div>
            <div class="col-sm-2" align="left" {% if rojo == true %}style="color: red;"{% endif %}>
                <h3>
                    <strong>
                        <ins>TURNOS</ins>
                    </strong>
                </h3>
                <h4>
                    Total: {{ informacion['cantidadTurnos'] }}<br>
                    Autorizados: {{ informacion['cantidadAutorizados'] }}
                </h4>
            </div>
            <div class="col-sm-4" align="left">
                <div class="cuadrado-azul"><i class="fa fa-bookmark"></i></div>
                <strong> ONLINE CON RESPUESTAS</strong>
                <br>

                <div class="cuadrado-rojo"><i class="fa fa-bookmark"></i></div>
                <strong> ONLINE SIN RESPUESTA</strong>
                <br>

                <div class="cuadrado-verde"><i class="fa fa-bookmark"></i></div>
                <strong> PERSONALES</strong>
                <br>

                <div class="cuadrado-amarillo"><i class="fa fa-bookmark"></i></div>
                <strong> MANUALES</strong>
            </div>
        {% endif %}

    </div>

    <div class="row form-blanco borde-top borde-left-4 borde-right-4">
        <div class="col-md-12">
            {{ content() }}
        </div>

        <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
            <table id="tabla" class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="th-titulo">Codigo</th>
                    <th class="th-titulo">Legajo</th>
                    <th class="th-titulo">Apellido y nombre</th>
                    <th class="th-titulo">Estado</th>
                    <th class="th-titulo">Fecha respuesta enviada</th>
                    <th class="th-titulo">Usuario</th>
                    <th class="th-titulo">Confirma Asistencia</th>
                    <th class="th-titulo">Imprimir Comprobante</th>
                </tr>
                </thead>

                <tbody>
                {% for item in page.items %}
                    {# Controlo el color de las filas: PERSONAL - ONLINE CHEQUEADO - ONLINE NO CHEQUEADO#}
                    {% if item['solicitudTurno_tipoTurnoId']==1 %}{#Online#}
                        {% if  item['solicitudTurno_respuestaChequeada']  == 1 %}
                            <tr style="background-color: rgba(126, 191, 227, 0.1)">{#azul#}
                        {% else %}
                            {% if  item['solicitudTurno_respuestaChequeada']  == 2 %}
                                <tr style="background-color: rgba(227, 100, 84, 0.1)">{#red#}
                            {% else %}
                                <tr style="background-color: rgba(227, 100, 84, 0.1)">{#red#}
                            {% endif %}
                        {% endif %}
                    {% elseif  item['solicitudTurno_tipoTurnoId']==3 %}{#Manual#}
                        <tr style="background-color: rgba(255, 211, 95, 0.1)">{#amarillo#}
                    {% else %}{#Personal 2#}
                        <tr style="background-color: rgba(19, 143, 44, 0.1)">{#verde#}
                    {% endif %}
                    <td class="td-posicion">{{ item['solicitudTurno_codigo'] }}</td>
                    <td class="td-posicion">{{ item['solicitudTurno_legajo'] }}</td>
                    <td class="td-posicion">{{ item['solicitudTurno_nomApe'] }}</td>
                    <td class="td-posicion"><strong>{{ item['solicitudTurno_estado'] }}</strong></td>
                    <td class="td-posicion">{{ date('d/m/Y',(item['solicitudTurno_fechaRespuestaEnviada']) | strtotime) }}</td>
                    <td class="td-posicion">{{ item['solicitudTurno_nickUsuario'] }}</td>
                    <td class="td-posicion">{{ item['solicitudTurno_tipoTurnoId'] }}{% if item['solicitudTurno_respuestaChequeada'] == 0 %}NO{% elseif item['solicitudTurno_respuestaChequeada'] == 1 %} SI{% else %}VENCIDO{% endif %}</td>
                    {# Controlo la celda Comprobante: Si es Terminal(2) o Manual(3), Si es Online(1) Chequeado o No Chequeado. #}
                    {% if item['solicitudTurno_tipoTurnoId']==1 %}{#Online#}
                        {% if  item['solicitudTurno_respuestaChequeada']  == 1 %}
                            <td class="td-posicion bg-azul-pl">
                                {{ link_to('turnos/comprobanteTurno/?id='~ base64(item['solicitudTurno_id']) ,'<i class="fa fa-print pull-left"></i> ONLINE ','class':'btn btn-info btn-block','target':'_blank') }}
                            </td>
                        {% else %}
                            {% if  item['solicitudTurno_respuestaChequeada']  == 2 %}
                                <td class="td-posicion bg-red-pl"> CANCELADO</td>
                            {% else %}
                                <td class="td-posicion bg-red-pl"> EN ESPERA</td>
                            {% endif %}
                        {% endif %}
                    {% elseif  item['solicitudTurno_tipoTurnoId']==3 %}{#Manual#}
                        <td class="td-posicion bg-yellow-pl">
                            {{ link_to('turnos/comprobanteTurno/?id='~ base64(item['solicitudTurno_id']) ,'<i class="fa fa-print pull-left"></i> MANUAL ','class':'btn btn-warning btn-block','target':'_blank') }}
                        </td>
                    {% else %}{#Terminal 2#}
                        <td class="td-posicion bg-green-pl">
                            {{ link_to('turnos/comprobanteTurno/?id='~ base64(item['solicitudTurno_id']) ,'<i class="fa fa-print pull-left"></i> PERSONAL ','class':'btn btn-success  btn-block','target':'_blank') }}
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
                            <a class="btn btn-gris"><strong>P&aacute;gina {{ page.current }}
                                    de {{ page.total_pages }}</strong></a>
                            {{ link_to("/turnos/turnosRespondidos/?page="~page.next,'Siguiente','class':'btn btn-gris') }}
                            {{ link_to("/turnos/turnosRespondidos/?page="~page.last,'Última','class':'btn btn-gris') }}
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
</section>


<script>

    $(document).ready(function(){
        $('#tabla').DataTable();
        function recargar() {
            table.ajax.reload();
        }
    });
</script>






