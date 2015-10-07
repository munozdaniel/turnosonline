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
{% if ( beneficio == false )or(persona == false) %}
    {#NO EXISTE LA PERSONA O NO POSEE BENEFICIOS#}
    <h2 style="text-align: center">CERTIFICADO NEGATIVO DE BENEFICIO</h2>
    <br>
    <p style="text-align: center"><strong>Nº de Documento: </strong>{{ nroDocumento }}</p>
    <div style="text-align: justify">
        <p>No se registra antecedente de Jubilación y/o Pensión del Instituto Municipal de Previsión Social de la
            Ciudad de Neuquén, a la fecha, para el número de documento ingresado en la consulta.-</p>
        <br>
        <p>La información registrada en este formulario es válida por 30 días a partir de la fecha de emisión.-</p>
        <p>No se requiere autenticación con sello y firma de un agente del I.M.P.S.</p>
        <br>
        <p style="text-align: center"><strong>Fecha de Emisión: </strong>{{ date("d/m/Y") }}</p>

    </div>

{% else %}
    {#LA PERSONA EXISTE Y POSEE BENEFICIOS#}
    <h2 style="text-align: center">CERTIFICADO DE BENEFICIO</h2>
    <br>
    <div style="text-align: left">
        <p><strong>Apellido/s y
                Nombre/s: </strong> {{ persona.datospersona_apellido~', '~ persona.datospersona_nombre }}</p>

        <p><strong>Tipo y Nº de Documento: </strong> {{ tipoDni.tipodoc_nombre ~' '~ persona.datospersona_nroDoc }}</p>

        <p><strong>Legajo: </strong> {{ beneficio.datosbeneficio_legajo }}</p>

        <p><strong>Tipo de
                Beneficio: </strong>{{ tipoBeneficio.tipobeneficio_grupo ~' '~ tipoBeneficio.tipobeneficio_nombre }}</p>
    </div>
    <br><br>
    <div style="text-align: justify">
        <p>La información registrada en este formulario es válida por 30 días a partir de la fecha de emisión.-</p>
        <br>
        <p style="text-align: center"><strong>Fecha de Emisión: </strong> {{ date("d/m/Y") }}</p>
        <br>
    </div>
{% endif %}
<footer style="vertical-align: bottom; margin-top:40%; text-align: center">
<p><em>Ante cualquier consulta, Ud. puede comunicarse al I.M.P.S. al teléfono <strong> 0299 4433978 int 25.</strong></em></p>
</footer>
</body>
</html>