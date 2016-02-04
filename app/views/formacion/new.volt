
{{ form("formacion/create", "method":"post") }}


{{ content() }}

<div class=" modal-header" align="left">
    <h1><ins>Formación Académica</ins><br><small> Ingrese los estudios más recientes</small></h1>
</div>
<table width="100%">
    <tr>
        <td align="left">{{ link_to("curriculum/ver/"~curriculumId, "Finalizar",'class':'btn btn-large btn-warning') }}</td>
        <td align="right">{{ link_to("informacion/new/"~curriculumId, "Continuar sin guardar",'class':'btn btn-large btn-success') }}</td>
    </tr>
</table>
<div class="modal-body col-md-12 ">
    {{ hidden_field('curriculum_id','value':curriculumId) }}
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_institucion' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_institucion') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_gradoId' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_gradoId') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_titulo' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_titulo') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_estadoId' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_estadoId') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_fechaInicio' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_fechaInicio') }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ experienciaForm.label('formacion_fechaFinal' ) }}
        </div>
        <div class="col-sm-4">
            {{ experienciaForm.render('formacion_fechaFinal') }}
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
    document.getElementById('formacion_estadoId').onchange = function() {
        if(document.getElementById('formacion_estadoId').value == 1 )//EN CURSO
        {
            document.getElementById('formacion_fechaFinal').disabled = true;
            document.getElementById("formacion_fechaFinal").required = false;
        }else{
            document.getElementById('formacion_fechaFinal').disabled = false;
            document.getElementById("formacion_fechaFinal").required = true;
        }
    };
</script>