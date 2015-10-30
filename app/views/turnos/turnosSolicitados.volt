<section id="certificacion">

    <style>
        a {color: #2da2c8}
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Listado de Solicitudes de Turnos</h2>
                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>

                    Periodo de solicitud de turnos: {{ fechaI }} - {{ fechaF }}
                    <br/>
                    Dia de atenci&oacute;n: {{ diaA }}
                    <br/>
                    Cantidad de solicitudes autorizadas: {{ cantA }}

                </div>
            </div>
        </div>

        {{ form('turnos/enviarRespuestas') }}

            <div class="row edicion">

                <div class="col-lg-16 col-md-16 ">
                    <table class="table table-striped table-bordered table-condensed" style="text-align: center !important;">
                        <thead>
                            <tr>
                                <th style="text-align: center;color:#2da2c8">Legajo</th>
                                <th style="text-align: center;color:#2da2c8">Apellido y nombre</th>
                                <th style="text-align: center;color:#2da2c8">Fecha solicitud</th>
                                <th style="text-align: center;color:#2da2c8">Estado</th>
                                <th style="text-align: center;color:#2da2c8">Monto m&aacute;ximo</th>
                                <th style="text-align: center;color:#2da2c8">Monto posible</th>
                                <th style="text-align: center;color:#2da2c8">Cantidad de cuotas</th>
                                <th style="text-align: center;color:#2da2c8">Valor cuota</th>
                                <th style="text-align: center;color:#2da2c8">Observaciones</th>
                                <th style="text-align: center;color:#2da2c8">Fecha revisi&oacute;n</th>
                                <th style="text-align: center;color:#2da2c8">Usuario</th>
                                <th style="text-align: center;color:#2da2c8">EDITAR</th>
                            </tr>
                        </thead>

                        <tbody>
                            {% for item in page.items %}
                                <tr>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_legajo'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nomApe'] }}</td>
                                    <td style="text-align: center;width: 180px">
                                        <?php $fechaModif = date('d-m-Y',strtotime($item['solicitudTurno_fechaPedido']))?> {{fechaModif}}
                                    </td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_estado'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_montoMax'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_montoPosible'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_cantCuotas'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_valorCuota'] }}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_observaciones'] }}</td>
                                    <td style="text-align: center;width: 180px"><?php if($item['solicitudTurno_fechaProcesamiento'] != null)
                                                    $fechaModif = date('d-m-Y',strtotime($item['solicitudTurno_fechaProcesamiento']));
                                                else
                                                    $fechaModif='-';?>{{fechaModif}}</td>
                                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nickUsuario'] }}</td>
                                    <td width="7%">{{ link_to("turnos/editarSolicitud/?id="~item['solicitudTurno_id'], 'Editar','class':'btn btn-info') }}</td>

                                </tr>
                            {% endfor %}
                        </tbody>

                        <tbody>
                            <tr>
                                <td colspan="12">
                                    <div align="center">
                                        {{ link_to("/turnos/turnosSolicitados/?page=1",'Primera','class':'btn') }}
                                        {{ link_to("/turnos/turnosSolicitados/?page="~page.before,' Anterior','class':'btn') }}
                                        {{ link_to("/turnos/turnosSolicitados/?page="~page.next,'Siguiente','class':'btn') }}
                                        {{ link_to("/turnos/turnosSolicitados/?page="~page.last,'Ultima','class':'btn') }}
                                        P&aacute;gina {{ page.current }} de {{ page.total_pages }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    {{ submit_button('ENVIAR RESPUESTAS','class':'btn btn-blue btn-lg btn-block') }}
                </div>
            </div>

        {{ end_form() }}
    </div>
</section>










