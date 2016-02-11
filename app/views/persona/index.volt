
{{ content() }}

<div align="right">
    {{ link_to("persona/new", "Create persona") }}
</div>

{{ form("persona/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search persona</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="persona_id">Persona</label>
        </td>
        <td align="left">
            {{ text_field("persona_id", "type" : "number",'pattern':'="[0-9]{8}"') }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_apellido">Persona Of Apellido</label>
        </td>
        <td align="left">
            {{ text_field("persona_apellido", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_nombre">Persona Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("persona_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_fechaNacimiento">Persona Of FechaNacimiento</label>
        </td>
        <td align="left">
                {{ text_field("persona_fechaNacimiento", "type" : "date") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_tipoDocumentoId">Persona Of TipoDocumentoId</label>
        </td>
        <td align="left">
            {{ text_field("persona_tipoDocumentoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_numeroDocumento">Persona Of NumeroDocumento</label>
        </td>
        <td align="left">
            {{ text_field("persona_numeroDocumento", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_sexo">Persona Of Sexo</label>
        </td>
        <td align="left">
            {{ text_field("persona_sexo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_nacionalidadId">Nacionalidad</label>
        </td>
        <td align="left">
            {{ text_field("persona_nacionalidadId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_localidadId"> Localidad</label>
        </td>
        <td align="left">
            {{ text_field("persona_localidadId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_telefono">Persona Of Telefono</label>
        </td>
        <td align="left">
            {{ text_field("persona_telefono", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_celular">Persona Of Celular</label>
        </td>
        <td align="left">
            {{ text_field("persona_celular", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_email">Persona Of Email</label>
        </td>
        <td align="left">
            {{ text_field("persona_email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_estadoCivilId">Persona Of EstadoCivilId</label>
        </td>
        <td align="left">
            {{ text_field("persona_estadoCivilId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_habilitado">Persona Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("persona_habilitado", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="persona_fechaCreacion">Persona Of FechaCreacion</label>
        </td>
        <td align="left">
                {{ text_field("persona_fechaCreacion", "type" : "date") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
