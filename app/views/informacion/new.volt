{{ content() }}

<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>Información General</ins>
        <br><h3 class="">
            <ins><small  style=" color:#FFF !important;">Idiomas / Aptitudes / Datos Adicionales / Preferencias</small></ins>
        </h3>
    </h1>
    <table class="" width="100%">
        <tr>
            <td align="right">{{ link_to("curriculum/ver"~curriculum_id, "<i class='fa fa-clone'></i> FINALIZAR ",'class':'btn btn-large btn-blue') }}</td>
        </tr>
    </table>
</div>
<hr>
<div class="modal-body col-md-12 ">

    {{ hidden_field('curriculum_id','value':curriculum_id) }}
    {{ form("idiomas/agregar","id":"agregarIdioma","method":"post", 'class':'curriculum-bg-form borde-top') }}

    <div class="row form-group">
        <div id="idiomas_mensaje" class="col-md-8 col-md-offset-2  ">
        </div>

        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ idiomaForm.label('idiomas_nombre' ) }}
        </div>
        <div class="col-sm-4">
            {{ idiomaForm.render('idiomas_nombre') }}
        </div>

    </div>
    <div class="row form-group">

        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ idiomaForm.label('idiomas_nivelId' ) }}
        </div>
        <div class="col-sm-4">
            {{ idiomaForm.render('idiomas_nivelId') }}
        </div>
        <div class="col-md-12"><br></div>
        <div class="col-md-10 col-md-offset-1">
            <fieldset class="">
                <legend class="legendStyle ">
                    <a data-toggle="collapse" data-target="#idiomas"  class="btn btn-gris" onclick="cargarIdiomas()"><i class="fa fa-pencil"></i> Ver idiomas</a>
                    <a class="btn  btn-info" onclick="agregarIdioma()"><i class="fa fa-plus"></i> Guardar idioma</a>
                </legend>
                <div class="row collapse " id="idiomas">
                        hola
                </div>
            </fieldset>
        </div>
    </div>

    {{ end_form() }}
    <script>
        function agregarIdioma (event) {
            var formData = {
                'idiomas_nombre'    : document.getElementById('idiomas_nombre').value,
                'idiomas_nivelId'   : document.getElementById('idiomas_nivelId').value,
                'curriculum_id'   : document.getElementById('curriculum_id').value
            };
            $.ajax({
                data: formData,
                method: "POST", 'class':'curriculum-bg-form borde-top',
                url: '/impsweb/idiomas/agregar',
                success: function (response) {
                    //alert(response);Sirve cuando no podemos ver el error.
                    parsed = $.parseJSON(response);
                    //console.log(response);//Co0mentar cuando funcione
                    var selectorIdioma = $('#idiomas_mensaje');
                    var idiomas = $('.idioma');
                    if(!parsed.success){
                        $('#idiomas_mensaje').empty();
                        for(var datos in parsed.errors)//Arma los mensajes con errores
                        {
                            selectorIdioma.append('<div class="idioma problema font-blanco">' + parsed.errors[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else
                    {
                        $('#idiomas_mensaje').empty();
                        selectorIdioma.append('<div class="idioma exito font-blanco"> El Idioma se ha guardado correctamente</div>'); // add the actual error message under our input
                        document.getElementById('idiomas_nombre').value='';//Vacia los inputs una vez guardado
                        document.getElementById('idiomas_nivelId').value='';
                    }
                },
                error: function (error) {
                    alert("ERROR : "+error.statusText) ;
                    console.log(error);
                }
            });
        };
    </script>
    <hr>
    <div class=" curriculum-bg-form borde-top">
    <div class="row form-group">
        <div id="conocimientos_mensaje" class="col-md-8 col-md-offset-2  ">
        </div>
        <div class="col-sm-8 col-md-2 col-md-offset-2">
            {{ informacionForm.label('conocimientos_nombre' ) }}
        </div>
        <div class="col-sm-8 col-md-4">
            {{ informacionForm.render('conocimientos_nombre') }}
            <small> Paquete Office, internet, email, etc.</small>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-8 col-md-2 col-md-offset-2">
            {{ informacionForm.label('conocimientos_nivelId' ) }}
        </div>
        <div class="col-sm-8 col-md-4">
            {{ informacionForm.render('conocimientos_nivelId') }}
        </div>
        <div class="col-sm-12"><hr>
            <a data-toggle="collapse" data-target="#conocimientos"  class="btn btn-gris" onclick="cargarConocimientos()"><i class="fa fa-pencil"></i> Ver idiomas</a>
            <a class="btn  btn-info" onclick="agregarConocimiento()"><i class="fa fa-plus"></i> Guardar Conocimiento</a>
        </div>
    </div>
    </div>
    <script>
        function agregarConocimiento (event) {
            var formData = {
                'conocimientos_nombre'    : document.getElementById('conocimientos_nombre').value,
                'conocimientos_nivelId'   : document.getElementById('conocimientos_nivelId').value,
                'curriculum_id'   : document.getElementById('curriculum_id').value
            };
            $.ajax({
                data: formData,
                method: "POST",
                url: '/impsweb/conocimientos/agregar',
                success: function (response) {
                    console.log(response);//Co0mentar cuando funcione
                    //alert(response);//Sirve cuando no podemos ver el error.
                    parsed = $.parseJSON(response);
                    var mensaje = $('#conocimientos_mensaje');
                    if(!parsed.success){
                        mensaje.empty();
                        for(var datos in parsed.mensaje)//Arma los mensajes con errores
                        {
                            mensaje.append('<div class="idioma problema font-blanco">' + parsed.mensaje[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else
                    {
                        mensaje.empty();
                        mensaje.append('<div class="idioma exito font-blanco"> La Aptitud/Curso se ha guardado correctamente</div>'); // add the actual error message under our input
                        document.getElementById('conocimientos_nombre').value='';//Vacia los inputs una vez guardado
                        document.getElementById('conocimientos_nivelId').value='';
                    }
                },
                error: function (error) {
                    alert("ERROR : "+error.statusText) ;
                    console.log(error);
                }
            });
        };
    </script>
    {#====================================================================================#}
    <hr>
    {{ form("empleo/create", "method":"post", 'class':'curriculum-bg-form borde-top') }}

     <div class=" col-md-2 pull-right text-info">
         {{ link_to('files/curriculum/puestos.pdf','<i class="fa fa-file-pdf-o"></i> VER ESTRUCTURA EN PDF','target':'_blank') }}

     </div>
    <div class="row form-group">
        <div class="col-sm-12 col-md-2 col-md-offset-2">
            {{ informacionForm.label('dependencia_id' ) }}
        </div>
        <div class="col-sm-4">
            {{ informacionForm.render('dependencia_id') }}
            {{ informacionForm.render('script_puestoDependencia') }}

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