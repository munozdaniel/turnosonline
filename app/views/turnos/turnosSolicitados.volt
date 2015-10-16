<div class="container">

    <div class="row col-lg-12 col-md-12">
        <div class="heading">
            <h2 class="wow fadeInLeftBig">Solicitud de Turnos</h2>
            <p></p>
        </div>
    </div>

    <style>
        a {color: #2da2c8}
    </style>


    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th style="text-align: center;color:#2da2c8">Legajo</th>
                <th style="text-align: center;color:#2da2c8">Apellido y nombre</th>
                <th style="text-align: center;color:#2da2c8">Fecha solicitud</th>
                <th style="text-align: center;color:#2da2c8">Estado</th>
                <th style="text-align: center;color:#2da2c8">Monto maximo</th>
                <th style="text-align: center;color:#2da2c8">Monto posible</th>
                <th style="text-align: center;color:#2da2c8">Cantidad de cuotas</th>
                <th style="text-align: center;color:#2da2c8">Valor cuota</th>
                <th style="text-align: center;color:#2da2c8">Observaciones</th>
                <th style="text-align: center;color:#2da2c8">Fecha revision</th>
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
                    <td style="text-align: center;width: 180px">
                        <?php if($item['solicitudTurno_fechaProcesamiento'] != null)
                                    $fechaModif = date('d-m-Y',strtotime($item['solicitudTurno_fechaProcesamiento']));
                                else
                                    $fechaModif='-';?>
                        {{fechaModif}}
                    </td>
                    <td style="text-align: center;width: 180px">{{ item['solicitudTurno_nickUsuario'] }}</td>


                  {# <td width="7%">{{ link_to("turnos/editarSolicitud2/"~item['solicitudTurno_id'], 'Editar','class':'btn btn-info') }}</td> #}

                    <td>
                        {{ form("turnos/editarSolicitud", 'method': 'post') }}
                            {{ hidden_field("idSolicitud", "value":item['solicitudTurno_id']) }}
                            <button name="etc" class="btn btn-info">
                                editar
                            </button>
                        {{ end_form() }}
                    </td>
                </tr>
            {% endfor %}
        </tbody>

        <tbody>
            <tr>
                <td colspan="12">
                    <div align="center">
                        {{ link_to("/turnos/turnosSolicitados/?page=1",'Primera| ') }}
                        {{ link_to("/turnos/turnosSolicitados/?page="~page.before,' Anterior| ') }}
                        {{ link_to("/turnos/turnosSolicitados/?page="~page.next,'Siguiente| ') }}
                        {{ link_to("/turnos/turnosSolicitados/?page="~page.last,'Ultima| ') }}
                        P&aacute;gina {{page.current}} de {{page.total_pages}}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

