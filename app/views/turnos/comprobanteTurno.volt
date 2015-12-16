<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>
<style>

</style>
<body>
{{ content() }}
<div align="center">
    {{ image('img/certificacion/certificacion-header.jpg','alt':'Header certificacion') }}

</div>

    {#LA PERSONA EXISTE Y POSEE BENEFICIOS#}
    <h2 style="text-align: center">COMPROBANTE DE TURNO</h2>
    <br>
    <div style="text-align: left margin-left:45px;">
        <h2><strong>Nro. de Turno: {{ solicitud.solicitudTurno_numero }}</h2>
        <p><strong>Fecha de confirmación: </strong>{{ solicitud.solicitudTurno_fechaConfirmacion }}</p>
        <p><strong>Apellido/s y
                Nombre/s: </strong> {{ solicitud.solicitudTurno_nomApe }}</p>

        <p><strong>Nº de Documento: </strong> {{ solicitud.	solicitudTurno_documento }}</p>

        <p><strong>Legajo: </strong> {{ solicitud.solicitudTurno_legajo }}</p>


    </div>

<footer style="vertical-align: bottom; margin-top:40%; text-align: center">
    <p><em>Ante cualquier consulta, Ud. puede comunicarse al I.M.P.S. al teléfono <strong> 0299 4433978 int 25.</strong></em></p>
</footer>
</body>
</html>