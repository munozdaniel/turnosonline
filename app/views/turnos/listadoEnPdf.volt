<!DOCTYPE html>
<html>

    <head lang="en">
        <meta charset="UTF-8">
    </head>

    <style>
        table.layout { border-collapse: separate;text-align: center;}
        th.layout{text-align: center;font-family:"Times New Roman"}
        td.layout{width: 100px;text-align: center;font-family:"Times New Roman"}
        h2.layout{text-align: center;font-family:"Times New Roman"}
        p.layout{font-family: "Times New Roman"}
    </style>

    <body>
        {{ content() }}

        <div align="center">
            {{ image('img/listado/Logo.jpg','width':'100px','height':'100px') }}
        </div>

            <h2 class="layout">LISTADO DE SOLICITUDES DE TURNOS</h2>
            <br>
            <div style="text-align: left">

                <p class="layout">Periodo para solicitar turnos: {{fechaI}} - {{ fechaF}}
                   <br/>
                    Dia de atenci&oacute;n de turnos: {{diaA}}
                    <br/><br/>
                   Cantidad de solicitudes autorizadas:{{cantAut}}
                </p>

                <table class="layout" border="1">
                    <thead>
                        <tr>
                            <th class="layout">LEGAJO</th>
                            <th class="layout">APELLIDO Y NOMBRE</th>
                            <th class="layout">NUMERO DE TELEFONO</th>
                            <th class="layout">ESTADO DE SOLICITUD</th>
                            <th class="layout">FECHA ENVIO RESPUESTA</th>
                            <th class="layout">USUARIO</th>
                            <th class="layout">RESPUESTA CONFIRMADA</th>
                        </tr>
                    </thead>

                    <tbody>
                        {% for unaSolicitud in listado %}
                            <tr>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_legajo'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_nomApe'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_numTelefono'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_estado'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_fechaRespuestaEnviadaDate'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_nickUsuario'] }}</td>
                                <td class="layout">{{ unaSolicitud['solicitudTurno_respChequedaTexto'] }}</td>
                            </tr>
                        {% endfor %}
                    </tbody>

                </table>

            </div>
    </body>
</html>