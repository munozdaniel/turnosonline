<section id="onepage">


    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="about_area">
                    <div class="heading">
                        <h2 class="wow fadeInLeftBig">Listado de Solicitudes de Turnos</h2>
                        <div class="pull-right">{{ link_to('administrar/index','class':'btn btn-lg btn-default btn-block btn-volver','<i class="fa fa-undo"></i> VOLVER') }}</div>
                    </div>



                </div>
            </div>
        </div>
        {{ content() }}

        {{ form('turnos/enviarRespuestas') }}

        <div class="row edicion">

            <div id="solicitudes" class="col-lg-16 col-md-16 table-responsive">
                <div >
                    <div class="fuente-16"> <strong><ins>Periodo de solicitud de turnos</ins>: </strong>{{ fechaI }} - {{ fechaF }}
                    </div>
                    <div class="fuente-16"> <strong><ins>Dia de atenci&oacute;n</ins>: </strong> {{ diaA }}
                    </div>
                    <br/>
                    <div id="#datos" class="fuente-16">
                        <strong><ins>Turnos autorizados:</ins>: </strong> {{ cantidadDeTurnos }}
                    </div>
                    <div id="#datos" class="fuente-16">
                        <strong><ins>Cantidad de solicitudes autorizadas</ins>: </strong> {{ autorizadosEnviados }}
                    </div>
                    <br>

                </div>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th style="text-align: center;color:#2da2c8">Legajo</th>
                        <th style="text-align: center;color:#2da2c8">Apellido y nombre</th>
                        <th style="text-align: center;color:#2da2c8">Fecha solicitud</th>
                        <th style="text-align: center;color:#2da2c8">Estado</th>
                        <th style="text-align: center;color:#2da2c8">Monto maximo</th>
                        <th style="text-align: center;color:#2da2c8">Monto posible</th>
                        <th style="text-align: center;color:#2da2c8">Cantidad de cuotas</th>
                        <th style="text-align: center;color:#2da2c8">Valor cuota</th>
                        <th style="text-align: center;color:#2da2c8">Observaciones</th>
                        <th style="text-align: center;color:#2da2c8">Fecha revision</th>
                        <th style="text-align: center;color:#2da2c8">Usuario</th>
                        <th style="text-align: center;color:#2da2c8">EDITAR</th>
                    </tr>
                    </thead>
                    <tbody>

                    {% for item in page.items %}
                        <tr>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_legajo }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_nomApe }}</td>
                            <td style="text-align: center;width: 180px">
                                {% set fechaModif =  date('d-m-Y',(item.solicitudTurno_fechaPedido) | strtotime) %}
                                {{ fechaModif }}
                            </td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_estado }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_montoMax }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_montoPosible }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_cantCuotas }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_valorCuota }}</td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_observaciones }}</td>
                            <td style="text-align: center;width: 180px">
                                {% if(item.solicitudTurno_fechaProcesamiento != null) %}
                                    {% set fechaModif = date('d-m-Y',(item.solicitudTurno_fechaProcesamiento) | strtotime) %}
                                {% else %}
                                    {% set fechaModif = '-' %}
                                {% endif %}
                                {#Mostramos la variable seteada con los valores anteriores.#}
                                {{ fechaModif }}
                            </td>
                            <td style="text-align: center;width: 180px">{{ item.solicitudTurno_nickUsuario }}</td>
                            <td width="7%">
                                {% if ((item.solicitudTurno_nickUsuario ==  session.get('auth')['usuario_nick'])
                                OR (session.get('auth')['rol_nombre']== "ADMIN") OR (session.get('auth')['rol_nombre'] == "SUPERVISOR")) %}
                                    <!--en el evento onclick pasamos el post en formato json-->
                                    <a href="#" class="btn btn-info editar"
                                       onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item)) ?>')">
                                        Editar
                                    </a>
                                {% else %}
                                    <a href="#" class="btn btn-gris editar" onclick="mensaje()">Editar </a>
                                {% endif %}
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="12">
                            <div align="center">
                                {{ link_to("/turnos/turnosSolicitados/?page=1",'Primera','class':'btn') }}
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.before,' Anterior','class':'btn') }}
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.next,'Siguiente','class':'btn') }}
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.last,'Ultima','class':'btn') }}

                                <div><p> P&aacute;gina {{ page.current }} de {{ page.total_pages }}</p></div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br/><br/>

        <div class="row">
            <div class="col-lg-3 col-lg-offset-4">
                {{ submit_button('ENVIAR RESPUESTAS','class':'btn btn-blue btn-lg btn-block') }}
            </div>
        </div>

        {{ end_form() }}
    </div>
    <!-- ==========================MODALES============================= -->
    <!-- Fin: Modal Info Optica -->
    <script type="text/javascript">

        function mensaje()
        {
            alert('Solo el usuario que esta revisando la solicitud puede modificarla.)');
        }


        //objeto javascript al que le añadimos toda la funcionalidad del crud
        var crudPhalcon = {};
        $(document).ready(function () {
            //mostramos la modal para editar un post con sus datos
            crudPhalcon.edit = function (post) {
                //en post tenemos todos los datos del post parseado
                var json = crudPhalcon.parse(post), html = "";
                $("#modalCrudPhalcon .modal-title").html("<strong>" + json.solicitudTurno_legajo + "</strong> |   <strong>NOMBRE:</strong> " + json.solicitudTurno_nomApe + " ESTADO: " +json.solicitudTurno_estado );


                /*============================ VERIFICANDO EN QUE ESTADO SE ENCUENTRA PARA ARMAR LA LISTA =============================*/

                var lista, editable = false, autorizacion = false;
                var cantidadDeTurnos = {{ cantidadDeTurnos }},
                        autorizadosEnviados = {{ autorizadosEnviados }};
                if (json.solicitudTurno_estado == "PENDIENTE") {
                    //Si es PENDIENTE cualquier usuario puede pasar a REVISION, salvo que no hayan turnos.
                    if ((autorizadosEnviados > 0) && (autorizadosEnviados == cantidadDeTurnos))
                        lista = ['DENEGADO POR FALTA DE TURNOS'];
                    else {
                        lista = ['REVISION'];
                    }
                } else {
                    if (json.solicitudTurno_estado == "REVISION"
                            || json.solicitudTurno_estado == "AUTORIZADO"){
                        lista = ['REVISION', 'AUTORIZADO', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                        editable =true;
                    }else {
                        if (json.solicitudTurno_estado == "DENEGADO"
                                || json.solicitudTurno_estado == "DENEGADO POR FALTA DE TURNOS") {
                            lista = [ 'REVISION', 'AUTORIZADO', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];

                        } else {
                            if (json.solicitudTurno_estado != 'PENDIENTE' || json.solicitudTurno_estado != 'REVISION'
                                    || json.solicitudTurno_estado != 'AUTORIZADO' || json.solicitudTurno_estado != 'DENEGADO') {
                                lista = ['PENDIENTE'];
                            }
                        }
                    }
                }
                /*============================ ARMANDO EL SELECT DE LOS ESTADOS SEGUN EL PUNTO ANTERIOR =============================*/

                //Creacion del div que contiene el select de los estados.
                var div = document.createElement("div");
                div.setAttribute("id", "Estados");

                var selectList = document.createElement("select");
                selectList.setAttribute("id", "solicitudTurno_estado");
                selectList.setAttribute("name", "solicitudTurno_estado");
                selectList.setAttribute("style", "width:100%;");
                selectList.setAttribute("onchange", "crudPhalcon.habilitarDeshabilitarSegunElEstado()");
                div.appendChild(selectList);
                //document.body.appendChild(div);//agrega el div al body. no me sirve.
                //Agrego los elementos al select
                for (var i = 0; i < lista.length; i++) {
                    var option = document.createElement("option");
                    option.setAttribute("value", lista[i]);
                    option.text = lista[i];
                    //Pregunto si es el estado anterior para que quede seleccionado.
                    if (lista[i] == json.solicitudTurno_estado)
                        option.setAttribute("selected", "true");
                    selectList.appendChild(option);
                }
                /*=========================== COMENZANDO A ARMAR EL FORMULARIO ==============================*/

                html += '<div class="row formulario-turnos" style="padding: 20px;">'
                html += '<?php echo $this->tag->form(array("turnos/edit", "method" => "post", "id" => "form")); ?>';
                //Agrego el div creado con el select al modal.
                html += '<div><label for="solicitudTurno_estado"> ESTADO </label></div>';
                html += div.innerHTML;//Muestra el codigo html.



                /*============================ MOSTRAR/OCULTAR EL FORMULARIO SEGUN EL ESTADO =============================*/

                if (editable) {//SI ES AUTORIZADO O REVISION, MOSTRAR FORM
                    html += '<div id="campos_editables" >';
                    html += '<input id="editable" name="editable" value="1" type="hidden" class="form-control">';//1 Editable / 0 No editable
                }
                else {//SI ES DENEGADO, DENEGADO POR FALTA DE TURNOS, PENDIENTE OCULTAR FORM
                    html += '<div id="campos_editables" class="ocultar">';
                    //ADEMAS SI ES DENEGADO, DEBE MOSTRAR LA LISTA DE CAUSAS
                    html += '<input id="editable" name="editable" value="0" type="hidden" class="form-control">';//1 Editable / 0 No editable
                }
                html += '<div> <label for="solicitudTurno_montoMax">Monto Máximo</label>';
                html += '<input type="number" min="0" id="solicitudTurno_montoMax" name="solicitudTurno_montoMax"  required  value="' + json.solicitudTurno_montoMax + '" class="form-control"></div>';
                html += '<div> <label for="solicitudTurno_montoPosible">Monto Posible</label>';
                html += '<input type="number" min="0" id="solicitudTurno_montoPosible" name="solicitudTurno_montoPosible"  required value="' + json.solicitudTurno_montoPosible + '" class="form-control"></div>';
                html += '<div> <label for="solicitudTurno_cantCuotas">Cantidad de Cuotas</label>';
                html += '<input type="number" min="0" id="solicitudTurno_cantCuotas" name="solicitudTurno_cantCuotas"  required value="' + json.solicitudTurno_cantCuotas + '" class="form-control"></div>';
                html += '<div> <label for="solicitudTurno_valorCuota">Valor de las Cuotas</label>';
                html += '<input type="number" min="0" id="solicitudTurno_valorCuota" name="solicitudTurno_valorCuota"  required value="' + json.solicitudTurno_valorCuota + '" class="form-control"></div>';
                html += '<div id="observacion" >';
                html += '<label for="solicitudTurno_observaciones">Observaciones</label>';
                html += '<textarea id="solicitudTurno_observaciones" maxlength="150"class="form-control" name="solicitudTurno_observaciones" rows="3">' + json.solicitudTurno_observaciones + '</textarea>';
                html += '</div>';
                html += '<input type="hidden" id="solicitudTurno_legajo" name="solicitudTurno_legajo"  value="' + json.solicitudTurno_legajo + '" class="form-control">';

                html += '<input type="hidden" id="solicitudTurno_id" name="solicitudTurno_id"  value="' + json.solicitudTurno_id + '" class="form-control">';
                html += '</div>';//fin campos_editables
                if(json.solicitudTurno_estado == "DENEGADO") {
                    html += '<div id="causaDenegado" >';
                }
                else{
                    html += '<div id="causaDenegado" class="ocultar">';
                }
                html += '<label for="causa">SELECCIONAR CAUSA</label><br>';
                html += '<select id="causa" name="causa" >';
                html += '<option value="NO CUMPLE CON EL 50% DEL CAPITAL ADEUDADO">No cumple con el 50% capital adeudado</option>';
                html += '<option value="SE ENCUENTRA EN ROJO">Se encuentra en rojo</option>';
                html += '<option value="NO CUMPLE CON LA ANTIGUEDAD">No cumple con la antiguedad</option>';
                html += '<option value="REFINANCIACION TOTAL">Refinanciacion total</option>';
                html += '</select>';
                html += '</div>';

                html += '<?php echo $this->tag->endForm() ?>';
                html += '</div>';//fin row

                $("#onclickBtn").attr("onclick", "crudPhalcon.editPost()").text("Editar").show();
                $("#modalCrudPhalcon .modal-body ").html(html);
                $("#modalCrudPhalcon").modal("show");
            },
                // Evento onChange del select estado.
                    crudPhalcon.habilitarDeshabilitarSegunElEstado = function () {
                        //Si esta autorizado puede modificar todos los campos, el div editor debe aparecer.
                        var solicitudTurno_estado = document.getElementById("solicitudTurno_estado");
                        var panel = document.getElementById("editor");

                        if (solicitudTurno_estado.options[solicitudTurno_estado.selectedIndex].value == "AUTORIZADO"
                        ) {
                            $("#campos_editables").removeClass('ocultar');
                            $("#causaDenegado").addClass('ocultar');
                        }
                        else {
                            if (solicitudTurno_estado.options[solicitudTurno_estado.selectedIndex].value == "DENEGADO")
                                $("#causaDenegado").removeClass('ocultar');
                            else
                                $("#causaDenegado").addClass('ocultar');
                            $("#campos_editables").addClass('ocultar');

                        }

                    },
                //hacemos la petición ajax para editar un post
                    crudPhalcon.editPost = function ()//procesamos la edición
                    {
                        $.ajax({
                            url: "<?php echo $this->url->get('turnos/edit') ?>",
                            data: $("#form").serialize(),
                            method: "POST",
                            success: function (data) {
                                //$('#solicitudes, #datos').load(document.URL +  ' #solicitudes',document.URL +  ' #datos');
                                $('#solicitudes').load(document.URL +  ' #solicitudes');
                                $("#modalCrudPhalcon .modal-body").html("").html(
                                        "<p >Post actualizado correctamente.</p>"
                                );
                                $("#onclickBtn").hide();
                                console.log(data);
                            },
                            error: function (error) {
                                alert(error.statusText);
                                console.log(error);
                            }
                        })
                    },

                //devuelve un json parseado para utilizar con javascript
                    crudPhalcon.parse = function (post) {
                        return JSON.parse(post);
                    },
                //devuelve el campo oculto para evitar csrf en phalcon
                    crudPhalcon.csrfProtection = function () {
                        return '<input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"' +
                                'value="<?php echo $this->security->getToken() ?>"/>';
                    }
        });
    </script>
    <!--ventana modal de bootstrap que utilizaremos para cada caso, crear, editar y eliminar-->
    <div class="modal fade" id="modalCrudPhalcon" tabindex="-1" role="dialog" aria-labelledby="modalCrudPhalconLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="cuerpo-modal col-sm-6 col-md-6 col-md-offset-3 ">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="onclickBtn" class="btn btn-success ">Enviar</button>
                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</section>









