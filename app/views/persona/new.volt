{{ form("persona/create", "method":"post") }}



<div align="center">
    <h1>Formá parte de IMPS / Trabajá con Nosotros</h1>

    <h3>Ingresa tus datos para cargar el curriculum</h3>
</div>

<table width="100%">
    <tr>
        <td align="left">{{ link_to("persona", "Volver",'class':'btn btn-large btn-warning') }}</td>
        <td align="right">{{ submit_button("Continuar >> ",'class':'btn btn-large btn-info') }}</td>
    </tr>
</table>
{{ content() }}

{% for element in formulario %}
    <div class="col-md-3 col-md-offset-2">
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                {{ element.render(['class': 'form-control']) }}
            </div>
        {% endif %}

    </div>

{% endfor %}

<div class="col-md-12">
{{ submit_button("Continuar >> ",'class':'btn btn-large btn-info') }}
</div>

</form>

