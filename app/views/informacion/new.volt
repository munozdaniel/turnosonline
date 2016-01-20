{{ content() }}

<div class="curriculum-bg-form modal-header" align="left">
    <h1>
        <ins>Información General</ins>
        <br>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">{{ link_to("curriculum/ver", "Finalizar",'class':'btn btn-large btn-warning') }}</td>
        </tr>
    </table>
</div>
<hr>
<div class="modal-body col-md-12 curriculum-bg-form borde-top">
    <h3 class="curriculum-titulo-form">
        <ins><small>Idiomas / Aptitudes / Datos Adicionales / Preferencias</small></ins>
    </h3>
    {{ hidden_field('curriculum_id','value':curriculum_id) }}
    {{ form("idiomas/create", "method":"post") }}

    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('idiomas_nombre' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('idiomas_nombre') }}
        </div>

    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('idiomas_nivelId' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('idiomas_nivelId') }}
        </div>
        <div class="col-sm-12 col-md-6 col-md-2" >
            {{ submit_button("Añadir",'class':'btn btn-block btn-info') }}
        </div>

    </div>
    {{ end_form() }}
    <hr>
    {{ form("conocimientos/create", "method":"post") }}

    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('conocimientos_nombre' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('conocimientos_nombre') }}
            <small> Paquete Office, internet, email, etc.</small>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('conocimientos_nivelId' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('conocimientos_nivelId') }}
        </div>
        <div class="col-sm-2">
            {{ submit_button("Añadir",'class':'btn btn-block btn-info') }}
        </div>
    </div>
    {{ end_form() }}
    <hr>
    {{ form("empleo/create", "method":"post") }}


    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('dependencia_id' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('dependencia_id') }}
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('puesto_id' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('puesto_id') }}
        </div>

    </div>

    <div id="puesto_otro" class="row form-group ocultar">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('puesto_otro' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('puesto_otro') }}
        </div>
    </div>

    <div id="sectorInteres" class="row form-group  ocultar">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('sectorInteres_id' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('sectorInteres_id') }}
        </div>

    </div>
    <div class="row form-group">
        <div class="col-sm-4">
            {{ informacionForm.render('script_puestoDependencia') }}
        </div>
        <div class="col-sm-4">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('empleo_disponibilidad' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('empleo_disponibilidad') }}
            <small> Ej: 8:00hs - 14:00hs, Full Time, etc.</small>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('empleo_carnet' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('empleo_carnet') }}
        </div>
        <div class="col-sm-2">
            {{ submit_button("Añadir",'class':'btn btn-block btn-info') }}
        </div>
    </div>
    {{ end_form() }}

</div>


<script type="text/javascript">
    document.getElementById('dependencia_id').onchange = function () {
        if (document.getElementById('dependencia_id').value == 1) {//ADMINISTRACION CENTRAL (Mostrar SectorInteres_id)
            $('#sectorInteres').show();
            document.getElementById("sectorInteres_id").required = true;
        } else {
            $('#sectorInteres').hide();
            document.getElementById("sectorInteres_id").required = false;
        }
    };
    document.getElementById('puesto_id').onchange = function () {
        if (document.getElementById('puesto_id').value == 21) {//Otro (Mostrar otro puesto)
            $('#puesto_otro').show();
            document.getElementById("puesto_otro").required = true;
        } else {
            $('#puesto_otro').hide();
            document.getElementById("puesto_otro").required = false;
        }
    };
</script>