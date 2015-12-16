<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>

<body>
{{ content() }}
<div align="center">
    {{ image('img/certificacion/certificacion-header.jpg','alt':'Header certificacion') }}

</div>

    {#LA PERSONA EXISTE Y POSEE BENEFICIOS#}
    <h1 class="layout" style="text-align: center"> NÚMERO DE TURNO:    {{ solicitud.solicitudTurno_numero }}</h1>
    <br>
    <table align="center">
        <tr>
            <td class="layout">Fecha de Confirmación </td>
            <td>{{  date('d/m/Y',(solicitud.solicitudTurno_fechaConfirmacion) | strtotime) }}</td>
        </tr>
        <tr>
            <td class="layout">Apellido/s y
                Nombre/s </td>
            <td>{{ solicitud.solicitudTurno_nomApe }}</td>
        </tr>

        <tr>
            <td class="layout">Legajo</td>
            <td> {{ solicitud.solicitudTurno_legajo }}</td>
        </tr>

        <tr>
            <td class="layout">Nº de Documento</td>
            <td> {{ solicitud.solicitudTurno_documento }}</td>
        </tr>
    </table>
    <br><br>

<footer style="vertical-align: bottom;  text-align: center">
    <p><em>Ante cualquier consulta, Ud. puede comunicarse al I.M.P.S. al teléfono <strong> 0299 4433978 int 25.</strong></em></p>
</footer>
</body>
</html>