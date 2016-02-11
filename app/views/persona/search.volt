
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("persona/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("persona/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Persona</th>
            <th>Persona Of Apellido</th>
            <th>Persona Of Nombre</th>
            <th>Persona Of FechaNacimiento</th>
            <th>Persona Of TipoDocumentoId</th>
            <th>Persona Of NumeroDocumento</th>
            <th>Persona Of Sexo</th>
            <th>Persona Of NacionalidadId</th>
            <th>Persona Of LocalidadId</th>
            <th>Persona Of Telefono</th>
            <th>Persona Of Celular</th>
            <th>Persona Of Email</th>
            <th>Persona Of EstadoCivilId</th>
            <th>Persona Of Habilitado</th>
            <th>Persona Of FechaCreacion</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for persona in page.items %}
        <tr>
            <td>{{ persona.getPersonaId() }}</td>
            <td>{{ persona.getPersonaApellido() }}</td>
            <td>{{ persona.getPersonaNombre() }}</td>
            <td>{{ persona.getPersonaFechanacimiento() }}</td>
            <td>{{ persona.getPersonaTipodocumentoid() }}</td>
            <td>{{ persona.getPersonaNumerodocumento() }}</td>
            <td>{{ persona.getPersonaSexo() }}</td>
            <td>{{ persona.getPersonaNacionalidadid() }}</td>
            <td>{{ persona.getPersonaLocalidadid() }}</td>
            <td>{{ persona.getPersonaTelefono() }}</td>
            <td>{{ persona.getPersonaCelular() }}</td>
            <td>{{ persona.getPersonaEmail() }}</td>
            <td>{{ persona.getPersonaEstadocivilid() }}</td>
            <td>{{ persona.getPersonaHabilitado() }}</td>
            <td>{{ persona.getPersonaFechacreacion() }}</td>
            <td>{{ link_to("persona/edit/"~persona.getPersonaId(), "Edit") }}</td>
            <td>{{ link_to("persona/delete/"~persona.getPersonaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("persona/search", "First") }}</td>
                        <td>{{ link_to("persona/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("persona/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("persona/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
