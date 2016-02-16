{{ content() }}

<div class="curriculum-bg-header modal-header " align="left">
    <h1>
        <ins>Información General</ins>
        <br>

        <h3 class="">
            <ins>
                <small style=" color:#FFF !important;">Idiomas / Aptitudes / Datos Adicionales / Preferencias</small>
            </ins>
        </h3>
    </h1>
    {% if curriculumId is defined %}

    <table class="" width="100%">
        <tr>
            <td align="right">{{ link_to("curriculum/ver/"~curriculumId, "<i class='fa fa-home'></i> MI PERFIL",'class':'btn btn-lg btn-primary') }}</td>
        </tr>
    </table>
    {% endif %}

</div>
<hr>
<div class="modal-body col-md-12 ">

    {{ form("idiomas/agregar","id":"agregarIdioma","method":"post", 'class':'curriculum-bg-form borde-top') }}


    {{ hidden_field('curriculum_id','value':curriculumId) }}

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
                    <a data-toggle="collapse" data-target="#idiomas" class="btn btn-gris" onclick="verIdiomas()"><i
                                class="fa fa-pencil"></i> Ver mis Idiomas</a>
                    <a class="btn  btn-info" onclick="agregarIdioma()"><i class="fa fa-plus"></i> Guardar idioma</a>
                </legend>
                <div class="row collapse " id="idiomas">
                    <div class="col-md-12">
                        <ul id="lista_idiomas" class="list-inline"></ul>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    {{ end_form() }}
    <script>

        function verIdiomas(event) {
            var formData = {
                'curriculum_id': document.getElementById('curriculum_id').value
            };
            $.ajax({
                data: formData,
                method: "POST", 'class': 'curriculum-bg-form borde-top',
                url: '/impsweb/idiomas/buscarIdiomasPorCurriculum',
                success: function (response) {
                    //alert(response);Sirve cuando no podemos ver el error.
                    arreglo = $.parseJSON(response);
                    //console.log(response);//Co0mentar cuando funcione
                    var selectorIdioma = $('#idiomas_mensaje');
                    var idiomas = $('.idioma');
                    if (!arreglo.success) {
                        $('#idiomas_mensaje').empty();
                        for (var datos in arreglo.mensaje)//Arma los mensajes con errores
                        {
                            selectorIdioma.append('<div class="idioma problema font-blanco">' + arreglo.mensaje + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        //$('#idiomas_mensaje').empty();
                        $('#lista_idiomas').empty();
                        //mostrar los idiomas
                        var ul = document.getElementById("lista_idiomas");
                        console.log(arreglo.idiomas);

                            for (var item in arreglo.idiomas)//Arma los mensajes con errores
                            {
                                //<li><a><i></i>nombre</a></li>
                                var elemt =arreglo.idiomas[item];
                                var li = document.createElement("li");
                                var i = document.createElement("i");
                                //<i class='fa fa-remove></i>
                                i.setAttribute('class','fa fa-remove');
                                li.appendChild(i);
                                //<li> <i><li>
                                li.setAttribute('class','tag tag-1 puntero');
                                li.setAttribute('onclick','eliminarIdioma('+elemt['idiomas_id']+')');
                                var nombre = document.createTextNode("  " + elemt['nombre'] + " "  );
                                li.appendChild(nombre);
                                var br = document.createElement("br");
                                li.appendChild(br);

                                var nivel = document.createTextNode("  [" + elemt['nivel'] + "] "  );
                                var small = document.createElement('small');
                                small.appendChild(nivel);
                                li.appendChild(small);

                                ul.appendChild(li);

                        }
                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });
        }
        /*===========================================================================*/
        function eliminarIdioma(idiomas_id) {
            $.ajax({
                method: "POST", 'class': 'curriculum-bg-form borde-top',
                url: '/impsweb/idiomas/delete/'+idiomas_id,
                success: function (response) {
                    //alert(response);Sirve cuando no podemos ver el error.
                    parsed = $.parseJSON(response);
                    //console.log(response);//Co0mentar cuando funcione
                    var selectorIdioma = $('#idiomas_mensaje');
                    var idiomas = $('.idioma');
                    if (!parsed.success) {
                        selectorIdioma.empty();
                        for (var datos in parsed.errors)//Arma los mensajes con errores
                        {
                            selectorIdioma.append('<div class="idioma problema font-blanco">' + parsed.errors[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        selectorIdioma.empty();
                        selectorIdioma.append('<div class="idioma exito font-blanco"> El Idioma se ha eliminado correctamente</div>'); // add the actual error message under our input
                        $("#idiomas").load(location.href+" #idiomas>*","");
                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });

        }
        /*===========================================================================*/
        function agregarIdioma(event) {
            var formData = {
                'idiomas_nombre': document.getElementById('idiomas_nombre').value,
                'idiomas_nivelId': document.getElementById('idiomas_nivelId').value,
                'curriculum_id': document.getElementById('curriculum_id').value
            };
            $.ajax({
                data: formData,
                method: "POST", 'class': 'curriculum-bg-form borde-top',
                url: '/impsweb/idiomas/agregar',
                success: function (response) {
                    //alert(response);Sirve cuando no podemos ver el error.
                    parsed = $.parseJSON(response);
                    //console.log(response);//Co0mentar cuando funcione
                    var selectorIdioma = $('#idiomas_mensaje');
                    var idiomas = $('.idioma');
                    if (!parsed.success) {
                        selectorIdioma.empty();
                        for (var datos in parsed.errors)//Arma los mensajes con errores
                        {
                            selectorIdioma.append('<div class="idioma problema font-blanco">' + parsed.errors[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        $("#idiomas").load(location.href+" #idiomas>*","");
                        selectorIdioma.empty();
                        selectorIdioma.append('<div class="idioma exito font-blanco"> El Idioma se ha guardado correctamente</div>'); // add the actual error message under our input
                        document.getElementById('idiomas_nombre').value = '';//Vacia los inputs una vez guardado
                        document.getElementById('idiomas_nivelId').value = '';
                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });
        }
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
            <div class="col-sm-12">
                <hr>
                <a data-toggle="collapse" data-target="#conocimientos" class="btn btn-gris"
                   onclick="verConocimientos()"><i class="fa fa-pencil"></i> Ver mis Aptitudes</a>
                <a class="btn  btn-info" onclick="agregarConocimiento()"><i class="fa fa-plus"></i> Guardar Aptitud</a>
                <div class="row collapse" id="conocimientos">
                    <div class="col-md-12">
                        <ul id="lista_conocimientos" class="list-inline"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function verConocimientos(event) {
            var formData = {
                'curriculum_id': document.getElementById('curriculum_id').value
            };
            $.ajax({
                    data: formData,
                method: "POST",
                url: '/impsweb/conocimientos/buscarConocimientosPorCurriculum',
                success: function (response) {
                    arreglo = $.parseJSON(response);
                    var selector = $('#conocimientos_mensaje');
                    if (!arreglo.success) {
                        console.log("verConocimientos: "+response);
                        selector.empty();
                        for (var datos in arreglo.mensaje)//Arma los mensajes con errores
                        {
                            selector.append('<div class="conocimiento problema font-blanco">' + arreglo.mensaje[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        //$('#conocimiento_mensaje').empty();
                        $('#lista_conocimientos').empty();
                        var ul = document.getElementById("lista_conocimientos");
                        for (var item in arreglo.conocimientos)//Arma los mensajes con errores
                        {
                            //<li><a><i></i>nombre</a></li>
                            var elemt =arreglo.conocimientos[item];
                            var li = document.createElement("li");
                            var i = document.createElement("i");

                            i.setAttribute('class','fa fa-remove');
                            li.appendChild(i);

                            li.setAttribute('class','tag tag-1 puntero');
                            li.setAttribute('onclick','eliminarConocimiento('+elemt['conocimiento_id']+')');
                            var nombre = document.createTextNode("  " + elemt['nombre'] + " "  );
                            li.appendChild(nombre);

                            var br = document.createElement("br");
                            li.appendChild(br);

                            var nivel = document.createTextNode("  [" + elemt['nivel'] + "] "  );
                            var small = document.createElement('small');
                            small.appendChild(nivel);
                            li.appendChild(small);

                            ul.appendChild(li);

                        }
                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });
        }
        /*===========================================================================*/
        function eliminarConocimiento(conocimiento_id) {
            $.ajax({
                method: "POST", 'class': 'curriculum-bg-form borde-top',
                url: '/impsweb/conocimientos/delete/'+conocimiento_id,
                success: function (response) {
                    console.log(response);//Co0mentar cuando funcione
                    parsed = $.parseJSON(response);
                    var mensaje = $('#conocimientos_mensaje');
                    if (!parsed.success) {
                        mensaje.empty();
                        for (var datos in parsed.mensaje)//Arma los mensajes con errores
                        {
                            mensaje.append('<div class="conocimiento problema font-blanco">' + parsed.mensaje[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        mensaje.empty();
                        mensaje.append('<div class="conocimiento exito font-blanco"> La Aptitud/Curso se ha eliminado correctamente</div>'); // add the actual error message under our input
                        $("#lista_conocimientos").load(location.href+" #lista_conocimientos>*","");
                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });

        }
        /*===========================================================================*/
        function agregarConocimiento(event) {
            var formData = {
                'conocimientos_nombre': document.getElementById('conocimientos_nombre').value,
                'conocimientos_nivelId': document.getElementById('conocimientos_nivelId').value,
                'curriculum_id': document.getElementById('curriculum_id').value
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
                    if (!parsed.success) {
                        mensaje.empty();
                        for (var datos in parsed.mensaje)//Arma los mensajes con errores
                        {
                            mensaje.append('<div class="idioma problema font-blanco">' + parsed.mensaje[datos] + '</div>'); // add the actual error message under our input
                        }
                    }
                    else {
                        $("#conocimientos").load(location.href+" #conocimientos>*","");
                        mensaje.append('<div class="idioma exito font-blanco"> La Aptitud/Curso se ha guardado correctamente</div>'); // add the actual error message under our input
                        mensaje.empty();
                        document.getElementById('conocimientos_nombre').value = '';//Vacia los inputs una vez guardado
                        document.getElementById('conocimientos_nivelId').value = '';

                    }
                },
                error: function (error) {
                    alert("ERROR : " + error.statusText);
                    console.log(error);
                }
            });
        }
        ;
    </script>
    {#====================================================================================#}
    <hr>
    <div id="div_empleo" class=" curriculum-bg-form borde-top">

        <div class=" col-md-2 pull-right text-info">
            {{ link_to('files/curriculum/puestos.pdf','<i class="fa fa-file-pdf-o"></i> VER ESTRUCTURA EN PDF','target':'_blank') }}
            {{ hidden_field('empleo_id','value':'') }}
        </div>
        <div class="row form-group">
            <div id="empleo_mensaje" class="col-md-8 col-md-offset-2  ">
            </div>
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
                {{ informacionForm.label('empleo_puestoOtro' ) }}
            </div>
            <div class="col-sm-4">
                {{ informacionForm.render('empleo_puestoOtro') }}
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
            <div class="col-sm-12">
                <hr>
                <a id="btn_agregar_empleo" class="btn  btn-info" onclick="agregarEmpleo()"><i class="fa fa-plus"></i> Guardar Datos Adicionales</a>
            </div>
        </div>
    </div>
</div>
<script>
    function agregarEmpleo(event) {

        var formData = {
            'dependencia_id': document.getElementById('dependencia_id').value,
            'puesto_id': document.getElementById('puesto_id').value,
            'puesto_otro': document.getElementById('empleo_puestoOtro').value,
            'sectorInteres_id': document.getElementById('sectorInteres_id').value,
            'empleo_disponibilidad': document.getElementById('empleo_disponibilidad').value,
            'empleo_carnet': document.getElementById('empleo_carnet').value,
            'curriculum_id': document.getElementById('curriculum_id').value
        };
        $.ajax({
            data: formData,
            method: "POST",
            url: '/impsweb/empleo/agregar',
            success: function (response) {
                console.log(response);//Co0mentar cuando funcione
                //alert(response);//Sirve cuando no podemos ver el error.
                parsed = $.parseJSON(response);
                var mensaje = $('#empleo_mensaje');
                if (!parsed.success) {
                    mensaje.empty();
                    for (var datos in parsed.mensaje)//Arma los mensajes con errores
                    {
                        mensaje.append('<div class="empleo problema font-blanco">' + parsed.mensaje[datos] + '</div>'); // add the actual error message under our input
                    }
                }
                else {
                    mensaje.empty();
                    mensaje.append('<div class="empleo exito font-blanco"> Los Datos se han guardado correctamente</div>'); // add the actual error message under our input
                    document.getElementById("btn_agregar_empleo").textContent = "Editar Datos Adicionales";
                    document.getElementById("btn_agregar_empleo").className  = "btn btn-gris";
                    document.getElementById("empleo_id").value  = parsed.empleo_id;

                }
            },
            error: function (error) {
                alert("ERROR : " + error.statusText);
                console.log(error);
            }
        });
    }
    ;
</script>
{#====================================================================================#}

<script type="text/javascript">
    document.getElementById('dependencia_id').onchange = function () {
        if (document.getElementById('dependencia_id').value == 1) {//ADMINISTRACION CENTRAL (Mostrar SectorInteres_id)
            $('#sectorInteres').show();
            $('#puesto_otro').hide();
            document.getElementById("empleo_puestoOtro").value = "";
            document.getElementById("sectorInteres_id").required = true;
        } else {
            $('#sectorInteres').hide();
            document.getElementById("sectorInteres_id").value = "";
            document.getElementById("sectorInteres_id").required = false;
        }
    };
    document.getElementById('puesto_id').onchange = function () {
        if (document.getElementById('puesto_id').value == 21) {//Otro (Mostrar otro puesto)
            $('#puesto_otro').show();
            document.getElementById("empleo_puestoOtro").required = true;
        } else {
            $('#puesto_otro').hide();
            document.getElementById("empleo_puestoOtro").value = "";
            document.getElementById("empleo_puestoOtro").required = false;
        }
    };
</script>