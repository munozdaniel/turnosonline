<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>AGREGAR EXPERIENCIA</ins>
        <br>

        <h3 class="">
            <em>
                <small style=" color:#FFF !important;">En esta sección podrá ingresar toda la información relacionada a su experiencia laboral.</small>
            </em>
        </h3>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">
                {{ link_to("curriculum/login", "Salir",'class':'btn btn-lg btn-primary') }}


            </td>
        </tr>
    </table>

</div>
<div class="modal-body col-md-12">

{{ form("experiencia/create","id":"form_expediente", "method":"post", 'class':'curriculum-bg-form borde-top') }}

{{ content() }}
    {% if curriculumId is defined %}
    <table width="100%" style="margin-bottom: 40px;">
        <tbody>
        <tr style="border-bottom: 1px solid #F3E7E7;">
            <td align="left">{{ link_to("curriculum/ver/"~curriculumId, "<i class='fa fa-home'></i> MI PERFIL",'class':'btn btn-lg btn-primary') }}</td>

            <td align="right">{{ link_to("formacion/new/"~curriculumId, "SALTAR ESTE PASO ►",'class':'btn btn-lg btn-primary') }}</td>
        </tr>
        </tbody>
    </table>
    {% endif %}
    {{ hidden_field('curriculum_id','value':curriculumId) }}
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('experiencia_empresa' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_empresa') }}
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('experiencia_rubro' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_rubro') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('experiencia_cargo' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_cargo') }}
        </div>
    </div>
    <div class="row form-group">
         <div class="col-sm-12 col-md-2 col-md-offset-2">
             {{ experienciaForm.label('experiencia_fechaInicio' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_fechaInicio') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.label('experiencia_fechaActual' ) }}<br>

            {{ experienciaForm.render('experiencia_fechaActual') }}
        </div>
    </div>
    <div class="row form-group">
         <div class="col-sm-12 col-md-2 col-md-offset-2">
             {{ experienciaForm.label('experiencia_fechaFinal' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_fechaFinal') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('experiencia_provinciaId' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_provinciaId') }}
        </div>
    </div>
    <div class="row form-group">
         <div class="col-sm-12 col-md-2 col-md-offset-2">
             {{ experienciaForm.label('experiencia_tareas' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_tareas') }}
        </div>
    </div>
    <div class="row form-group">
         <div class="col-sm-12 ">
             <hr>
            {{ submit_button("GRABAR Y AÑADIR OTRO",'name':'anadir','class':'btn btn-lg btn-info') }}
            {{ submit_button("GRABAR Y CONTINUAR ►",'name':'agregar','class':'btn btn-lg btn-primary') }}
        </div>
    </div>

{{ end_form() }}
</div>
<script type="text/javascript">
    document.getElementById('experiencia_fechaActual').onchange = function() {
        document.getElementById('experiencia_fechaFinal').disabled = this.checked;
        document.getElementById('experiencia_fechaFinal').required = !this.checked;
    };
</script>