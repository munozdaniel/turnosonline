<!DOCTYPE html>
<html>

    <head lang="en">
        <meta charset="UTF-8">
    </head>

    <body>
        {{ content() }}
        {% if mensaje == 'EXITO' %}

            <div align="center">
                {{ image('img/certificacion/certificacion-header.jpg','alt':'Header certificacion') }}
            </div>

            {#LA PERSONA EXISTE Y POSEE BENEFICIOS#}

            <table  align="center" style="border: 2px solid #000; padding:25px; width: 500px;">
                <tr >
                    <td class="layout"  align="left" style="font-weight: bold; font-size: 20px;">Código de Turno </td>
                    <td align="right" style="font-weight: bold; font-size: 20px;">  {{ solicitud.solicitudTurno_codigo }}</td>
                </tr>
                <tr>
                    <td class="layout"  align="left" >Fecha de Confirmación </td>
                    <td align="right" >{{  date('d/m/Y',(solicitud.solicitudTurno_fechaConfirmacion) | strtotime) }}</td>
                </tr>
                <tr>
                    <td class="layout"  align="left" >Apellido/s y Nombre/s </td>
                    <td align="right" >{{ solicitud.solicitudTurno_nomApe }}</td>
                </tr>

                <tr>
                    <td class="layout"  align="left" >Legajo</td>
                    <td align="right" > {{ solicitud.solicitudTurno_legajo }}</td>
                </tr>

                <tr>
                    <td class="layout"  align="left" >Nº de Documento</td>
                    <td align="right" > {{ solicitud.solicitudTurno_documento }}</td>
                </tr>
                <tr>
                    <td class="layout"  align="left">Período de Atención</td>
                    <td align="right" style="font-weight: bold;"> {{ date('d/m/Y',( solicitud.getFechasturnos().getFechasturnosDiaatencion()) | strtotime) }} al {{ date('d/m/Y',( solicitud.getFechasturnos().getFechasturnosDiaatencionfinal()) | strtotime) }} </td>
                </tr>
            </table>

            <br/><br/>

            <footer style="vertical-align: bottom;  text-align: center">
                <p><em>Ante cualquier consulta, Ud. puede comunicarse al I.M.P.S. al teléfono <strong> (0299) 4433978 int 10.</strong></em></p>
            </footer>
        {% else %}
            <h3>Ocurrió un error al generar el comprobante.</h3>
            <p><em> Ud. puede comunicarse al I.M.P.S. al teléfono <strong> (0299) 4433978 int 10.</strong></em></p>
        {% endif %}

    </body>
</html>