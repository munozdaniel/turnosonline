<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>FORMACIÓN ACADÉMICA</ins>
        <br>

        <h3 class="">
            <em>
                <small style=" color:#FFF !important;">En esta sección podrá agregar sus grados y títulos obtenidos.</small>
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
<div class="modal-body col-md-12 ">


{{ form("formacion/create", "method":"post", 'class':'curriculum-bg-form borde-top') }}


{{ content() }}
    {% if curriculumId is defined %}
    <table width="100%" style="margin-bottom: 40px;">
        <tbody>
        <tr style="border-bottom: 1px solid #F3E7E7;">
            <td align="left">{{ link_to("curriculum/ver/"~curriculumId, "<i class='fa fa-home'></i> MI PERFIL",'class':'btn btn-lg btn-primary') }}</td>
            <td align="right">{{ link_to("informacion/new/"~curriculumId, "SALTAR ESTE PASO ►",'class':'btn btn-lg btn-primary') }}</td>
        </tr>
        </tbody>
    </table>
    {% endif %}
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
            <hr>
            {{ submit_button("GRABAR Y AÑADIR OTRO",'name':'anadir','class':'btn btn-lg btn-info') }}
            {{ submit_button("GRABAR Y CONTINUAR ►",'name':'agregar','class':'btn btn-lg btn-primary') }}
        </div>
    </div>

{{ end_form() }}
</div>

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