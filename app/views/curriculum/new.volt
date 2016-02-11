
{{ form("curriculum/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create curriculum</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="curriculum_personaId">Curriculum Of PersonaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_personaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_experienciaId">Curriculum Of ExperienciaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_experienciaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_formacionId">Curriculum Of FormacionId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_formacionId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_idiomasId">Curriculum Of IdiomasId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_idiomasId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_informaticaId">Curriculum Of InformaticaId</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_informaticaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="curriculum_habilitado">Curriculum Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("curriculum_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
