<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>EDITAR EXPERIENCIA LABORAL</ins>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">
                {{ link_to("curriculum/login", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}
            </td>
        </tr>
    </table>
</div>
<div class="modal-body col-md-12"  align="left">
{{ form("experiencia/save", "method":"post", 'class':'curriculum-bg-form borde-top') }}
    {{ link_to("curriculum/ver/"~curriculum_id,'<i class="fa fa-reply"></i> VOLVER','class':'btn btn-lg btn-info font-bold') }}
    <hr>
    {{ content() }}
    <fieldset>

        {% for element in form %}

            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                {{ element }}
            {% else %}
                <div class="row form-group">
                    <div class="col-md-2 col-md-offset-3">
                    {{ element.label() }}
                    </div>
                    <div class="col-md-4">
                        {{ element.render() }}
                    </div>
                </div>

            {% endif %}
        {% endfor %}
        <div class="col-md-4 col-md-offset-4">
            <hr>
            {{ submit_button("GUARDAR CAMBIOS ",'class':'btn btn-lg btn-block  btn-info font-bold') }}
        </div>
    </fieldset>


    {{ end_form() }}
</div>
<script type="text/javascript">
    document.getElementById('experiencia_fechaActual').onchange = function() {
        document.getElementById('experiencia_fechaFinal').disabled = this.checked;
        document.getElementById('experiencia_fechaFinal').required = !this.checked;
    };
</script>