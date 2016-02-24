<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>EDITAR DATOS PERSONALES</ins>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">
                {{ link_to("curriculum/login", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}
            </td>
        </tr>
    </table>
</div>
<div class="modal-body col-md-12" align="left">

    {{ form("persona/save", "method":"post", 'class':'curriculum-bg-form borde-top') }}
    {% if curriculum_id is defined %}
        {{ link_to("curriculum/ver/"~curriculum_id,'<i class="fa fa-reply"></i> VOLVER','class':'btn btn-lg btn-info font-bold') }}
    {% else %}
        {{ link_to("curriculum/login/",'<i class="fa fa-home"></i> SALIR','class':'btn btn-lg btn-info font-bold') }}
    {% endif %}
    <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
           value="<?php echo $this->security->getToken() ?>"/>
    <hr>
    {{ content() }}
    <fieldset>

        {% for element in form %}

            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                {{ element }}
            {% else %}
                <div class="col-md-4">
                    <div class="form-group">
                        {{ element.label() }}
                        {{ element.render() }}
                    </div>
                </div>
            {% endif %}
        {% endfor %}
        <div class="col-md-4">
            <hr>
            {{ submit_button("GUARDAR CAMBIOS ",'class':'btn btn-lg btn-block  btn-info font-bold') }}
        </div>
    </fieldset>


    {{ end_form() }}
</div>
