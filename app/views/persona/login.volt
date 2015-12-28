
{{ content() }}


{{ form("persona/verificarDatos", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Iniciar Sesión</h1>
</div>

<table>


    <tr>
        <td align="right">
            <label for="persona_numeroDocumento">Nro Documento</label>
        </td>
        <td align="left">
            {{ text_field("persona_numeroDocumento", "size" : 30, 'required':'true', 'type':'number') }}
        </td>
    </tr>

    <tr>
        <td align="right">
            <label for="persona_email">Email</label>
        </td>
        <td align="left">
            {{ email_field("persona_email", "size" : 30, 'required':'true') }}
        </td>
    </tr>


    <tr>
        <td></td>
        <td>{{ submit_button("Ingresar",'class':'btn btn-large btn-info') }}</td>
    </tr>
</table>

</form>
