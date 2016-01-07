{{ form("experiencia/create","id":"form_expediente", "method":"post") }}

{{ content() }}

<div class=" modal-header" align="left">
    <h1><ins>Experiencia Laboral</ins></h1>
</div>
<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum/ver", "Finalizar",'class':'btn btn-large btn-warning') }}</td>
        <td align="right">{{ link_to("formacion/new/curriculumId=?"~curriculumId, "Continuar sin guardar",'class':'btn btn-large btn-success') }}</td>
    </tr>
</table>
<div class="modal-body col-md-12">
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
             {{ experienciaForm.label('experiencia_fechaFinal' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_fechaFinal') }}
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
             {{ experienciaForm.label('experiencia_tareas' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('experiencia_tareas') }}
        </div>
    </div>
    <div class="row form-group">
         <div class="col-sm-12 ">
            {{ submit_button("Guardar y Añadir Otro",'name':'anadir','class':'btn btn-large btn-info') }}
            {{ submit_button("Guardar y Continuar",'name':'agregar','class':'btn btn-large btn-success') }}
        </div>
    </div>
</div>

{{ end_form() }}
<script type="text/javascript">
    document.getElementById('experiencia_fechaActual').onchange = function() {
        document.getElementById('experiencia_fechaFinal').disabled = this.checked;
    };
</script>