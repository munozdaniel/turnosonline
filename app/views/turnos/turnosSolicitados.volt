{#Estilos para las tablas y loading#}
{{ stylesheet_link('css/style_turnos.css') }}-->

<div id="loader_bg" style="display: none;" align="center">
    <div id="loader_gif" style="display: none;">&nbsp;</div>
    <p class="loader_text pulse1">ENVIANDO</p>
</div>
<section id="onepage" class="admin bg_line">
    <div class="container">

        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>LISTA DE TURNOS SOLICITADOS</ins>
                    {{ link_to("administrar", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary','style':'margin-left:35%;background-color:#195889;') }}
                    <br>
                </h1>

                <h3>
                    <small><em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos
                            afiliados que han solicitado un turno.</em></small>
                </h3>

            </div>
        </div>

        <hr>

        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            {% if informacion is defined %}
                <div class="col-sm-4" align="center">
                    <h3><strong>
                            <ins>PERIODO DE SOLICITUD</ins>
                        </strong>
                    </h3>
                    <h4>
                        Desde {{ informacion['fechaInicio'] }} <br> Hasta {{ informacion['fechaFinal'] }}
                    </h4>

                </div>
                <div class="col-sm-4" align="center">
                    <h3>
                        <strong>
                            <ins>PERIODO DE ATENCI&Oacute;N</ins>
                        </strong>
                    </h3>
                    <h4>
                        Desde {{ informacion['diaAtencion'] }}
                        <br>Hasta {{ informacion['diaAtencionFinal'] }}
                    </h4>
                </div>
                <div id="cantAutorizados">
                    <div class="col-sm-4" align="left" {% if rojo == true %}style="color: red;"{% endif %}>
                        <h3>
                            <strong>
                                <ins>TURNOS</ins>
                            </strong>
                        </h3>
                        <h4>
                            Total: {{ informacion['cantidadTurnos'] }}<br>
                            Autorizados: {{ informacion['cantidadAutorizados'] }}
                            {{ hidden_field('cantidadTurnos','value':informacion['cantidadTurnos'] ) }}
                            {{ hidden_field('cantidadAutorizados','value':informacion['cantidadAutorizados'] ) }}
                        </h4>
                    </div>
                </div>

            {% endif %}

        </div>

        <div class="row form-blanco borde-top borde-left-4 borde-right-4">
            <div class="col-md-12">
                {{ content() }}
                {{ flashSession.output() }}
                <div id="mensaje_resultado" class="modal-body" align="left">
                    <div class="alerta_mensaje"></div>
                </div>
            </div>
            <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="th-estilo">Tipo</th>
                        <th class="th-estilo">Fecha solicitud</th>
                        <th class="th-estilo">Afiliado</th>
                        <th class="th-estilo">Fecha revisión</th>
                        <th class="th-estilo">Atendido por</th>
                        <th class="th-estilo">Estado</th>
                        <th class="th-estilo">Observaciones</th>
                        <th class="th-estilo">EDITAR</th>
                    </tr>
                    </thead>
                    <tbody>

                    {% for item in page.items %}
                        <tr>

                            <td style="vertical-align: middle">
                                {% if item.getSolicitudturnoTipoturnoid()==1 %}
                                    <button class="btn btn-info btn-block">{{ item.getTipoturno().getTipoTurnoNombre() }}</button>
                                {% else %}
                                    <button class="btn btn-block btn-success">{{ item.getTipoturno().getTipoTurnoNombre() }}</button>
                                {% endif %}
                            </td>

                            <td class="td-estilo">
                                <i class="fa fa-calendar"></i> {{ date('d/m/Y',(item.getSolicitudTurnoFechaPedido()) | strtotime) }}
                            </td>

                            <td class="td-estilo">
                                <h4>
                                    <ins>{{ item.getSolicitudTurnoLegajo() }} </ins>
                                </h4>{{ item.getSolicitudTurnoNomApe() }}
                            </td>

                            <td class="td-estilo">
                                {% if(item.getSolicitudTurnoFechaProcesamiento() != null) %}
                                    {% set fechaModif = date('d/m/Y',(item.getSolicitudTurnoFechaProcesamiento()) | strtotime) %}
                                {% else %}
                                    {% set fechaModif = '<p class="font-rojo" style="display:inline-block;">PENDIENTE</p> ' %}
                                {% endif %}
                                {#Mostramos la variable seteada con los valores anteriores.#}
                                <i class="fa fa-calendar"></i> {{ fechaModif }}
                            </td>

                            <td class="td-estilo">{{ item.getSolicitudTurnoNickUsuario() }}</td>

                            <td class="td-estilo">
                                <strong> <a class="btn btn-block "> {{ item.getSolicitudTurnoEstado() }}</a></strong>
                            </td>

                            <td class="td-observaciones" title="{{ item.getSolicitudTurnoObservaciones() }}">
                                {{ item.getSolicitudTurnoObservaciones() }}
                            </td>

                            <td width="7%">
                                {% if ((item.getSolicitudTurnoNickUsuario() ==  session.get('auth')['usuario_nick'])
                                OR (session.get('auth')['rol_nombre']== "ADMIN")
                                OR (session.get('auth')['rol_nombre'] == "SUPERVISOR")) %}

                                    <a class="btn editar" style="background-color: #85B8D6;color:darkslategrey;"
                                       onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item->toArray())) ?>')">
                                        <i class="fa fa-pencil-square"></i> EDITAR</a>

                                {% elseif(item.getSolicitudTurnoNickUsuario() == '-') %}

                                    {% if( informacion['cantidadAutorizados']  <  informacion['cantidadTurnos'] ) %}
                                        <a class="btn editar" style="background-color: #85B8D6;color:darkslategrey;"
                                           onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item->toArray())) ?>')">
                                            <i class="fa fa-pencil"></i> EDITAR</a>
                                    {% else %}
                                        <a href="#" class="btn btn-danger editar btn-block"
                                           onclick="alert('NO HAY TURNOS DISPONIBLES')">SIN TURNOS </a>
                                    {% endif %}

                                {% else %}
                                    <a href="#" class="btn btn-gris editar" onclick="mensaje()">SIN PERMISOS </a>
                                {% endif %}
                            </td>

                        </tr>
                    {% endfor %}
                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="16">
                            <div align="center">
                                {{ link_to("/turnos/turnosSolicitados/?page=1",'Primera','class':'btn btn-primary') }}
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.before,' Anterior','class':'btn btn-primary') }}
                                <div class="btn-primary btn">P&aacute;gina {{ page.current }}
                                    de {{ page.total_pages }}</div>
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.next,'Siguiente','class':'btn btn-primary') }}
                                {{ link_to("/turnos/turnosSolicitados/?page="~page.last,'Última','class':'btn btn-primary') }}

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{ form('turnos/enviarRespuestas') }}

            <div class="row">
                <div align="center" class="btn_enviarRespuestas col-xs-12 col-sm-12 col-md-5 col-md-offset-3">
                    <a class=" btn btn-primary btn-lg btn-block" style="border: solid black;"
                       ondblclick="enviarRespuestas()"> ENVIAR RESPUESTA A LOS AFILIADOS (doble click)</a>
                </div>
            </div>

            {{ end_form() }}
        </div>

    </div>
</section>
<!-- ====================================== -->

<script type="text/javascript">
    /**
     * Se encarga de mostrar la imagen de 'loading', de llamar al enviarRespuestasAjax y
     * de mostrar los mensajes correspondientes
     */
    function enviarRespuestas() {
        $('#loader_gif').fadeIn();
        $('#loader_bg').delay(100).fadeIn('slow');
        //$('body').delay(100).css({'overflow': 'visible'});
        //==========
        $.ajax({
            type: 'POST',
            url: '/impsweb/turnos/enviarRespuestasAjax',
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    //console.log(data);
                    $('.alerta_mensaje').remove();
                    if (!data.success) {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<h3><strong>Advertencia!</strong></h3><hr>' + data.mensaje + '<hr>' + data.errores + '</div>');
                    } else {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-success alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong>Operación Exitosa!</strong><hr>' + data.mensaje + '</div>');
                    }
                })
                .fail(function (data) {
                    console.log(data);
                })
                .always(function (data) {
                    $('#solicitudes').load(document.URL + ' #solicitudes');
                    $('#loader_gif').fadeOut();
                    $('#loader_bg').delay(100).fadeOut('slow');
                    console.log(data);
                });
    }

    /*==========================================================*/
    $(".problema").fadeTo(4000, 500).slideUp(500, function () {
        $(".problema").alert('close');
    });
    var myVar = setInterval(function () {
        myTimer()
    }, 10000);

    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
        $('#solicitudes').load(document.URL + ' #solicitudes');
    }

    //objeto javascript al que le añadimos toda la funcionalidad del crud
    var crudPhalcon = {};

    $(document).ready(function () {
        //mostramos la modal para editar un post con sus datos
        function armarModal(json) {
            //en post tenemos todos los datos del post parseado
            var  html = "";
            //console.log(json);
            $("#modalCrudPhalcon .modal-title").html("<strong>" + json.solicitudTurno_legajo + "</strong> |   <strong>NOMBRE:</strong> " + json.solicitudTurno_nomApe + " <strong> ESTADO: </strong> " + json.solicitudTurno_estado);
            $("#modalCrudPhalcon").show();


            /*============================ VERIFICANDO EN QUE ESTADO SE ENCUENTRA PARA ARMAR LA LISTA ============*/
            var limpiarForm = false;
            var lista, editable = false, autorizacion = false;
            var autorizadosEnviados = parseInt({{ informacion['autorizadosEnviados'] }});
            var sinTurnos = false;
            var turnosAutorizados = parseInt(document.getElementById("cantidadAutorizados").value);
            var cantidadDeTurnos = parseInt(document.getElementById("cantidadTurnos").value);
            if (turnosAutorizados >= cantidadDeTurnos) {
                sinTurnos = true;
                alert("NO HAY TURNOS DISPONIBLES PARA AUTORIZAR.");

            }
            lista = ['REVISION'];
            if (json.solicitudTurno_estado == "REVISION") {
                if (sinTurnos)
                    lista = ['REVISION', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                else {
                    lista = ['REVISION', 'AUTORIZADO', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                    editable = true;
                }
            }
            if (json.solicitudTurno_estado == "AUTORIZADO") {
                lista = ['AUTORIZADO', 'REVISION', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                editable = true;
            }
            if (json.solicitudTurno_estado == "DENEGADO"
                    || json.solicitudTurno_estado == "DENEGADO POR FALTA DE TURNOS") {
                if (sinTurnos)
                    lista = ['REVISION', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                else {
                    editable = false;
                    lista = ['REVISION', 'AUTORIZADO', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                }
            }


            /*============================ ARMANDO EL SELECT DE LOS ESTADOS SEGUN EL PUNTO ANTERIOR ===============*/

            //Creacion del div que contiene el select de los estados.
            var divEstado = document.createElement("div");
            divEstado.setAttribute("id", "Estados");

            var selectList = document.createElement("select");
            selectList.setAttribute("id", "solicitudTurno_estado");
            selectList.setAttribute("name", "solicitudTurno_estado");
            selectList.setAttribute("class", "form-control");
            selectList.setAttribute("onchange", "crudPhalcon.habilitarDeshabilitarSegunElEstado()");
            divEstado.appendChild(selectList);

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
            /*=========================== COMENZANDO A ARMAR EL FORMULARIO =======================================*/

            html += '<div class="row formulario-turnos" style="padding: 20px;">';
            if (sinTurnos)
                html += '<div class="col-md-6 col-md-offset-3"><h3 class="btn btn-warning" align="center"><strong> <i class="fa fa-warning"></i> ADVERTENCIA: NO HAY TURNOS DISPONIBLES PARA AUTORIZAR. </strong></h3></div>'
            html += '<div class="col-md-6 col-md-offset-3">';
            html += '<?php echo $this->tag->form(array("turnos/edit", "method" => "post", "id" => "form")); ?>';

            //Agrego el div creado con el select al modal.
            html += '<div><label for="solicitudTurno_estado"> ESTADO </label></div>';
            html += divEstado.innerHTML;//Muestra el codigo html.

            /*============================ MOSTRAR/OCULTAR EL FORMULARIO SEGUN EL ESTADO =========================*/

            if (editable) {//SI ES AUTORIZADO O REVISION, MOSTRAR FORM
                html += '<div id="campos_editables" >';
                html += '<input id="editable" name="editable" value="1" type="hidden" class="form-control">';//1 Editable / 0 No editable
            }
            else {//SI ES DENEGADO, DENEGADO POR FALTA DE TURNOS, PENDIENTE OCULTAR FORM
                html += '<div id="campos_editables" class="ocultar">';
                //ADEMAS SI ES DENEGADO, DEBE MOSTRAR LA LISTA DE CAUSAS
                html += '<input id="editable" name="editable" value="0" type="hidden" class="form-control">';//1 Editable / 0 No editable
            }

            html += '<div id="observacion" >';
            html += '<label for="solicitudTurno_observaciones">Observaciones</label>';
            html += '<textarea id="solicitudTurno_observaciones" maxlength="150"class="form-control" name="solicitudTurno_observaciones" placeholder="INGRESE UNA OBSERVACIÓN" rows="3">' + json.solicitudTurno_observaciones + '</textarea>';
            html += '</div>';
            html += '<input type="hidden" id="solicitudTurno_legajo" name="solicitudTurno_legajo"  value="' + json.solicitudTurno_legajo + '" class="form-control">';
            html += '<input type="hidden" id="solicitudTurno_id" name="solicitudTurno_id"  value="' + json.solicitudTurno_id + '" class="form-control">';
            html += '</div>';//fin campos_editables
            if (json.solicitudTurno_estado == "DENEGADO") {
                html += '<div id="causaDenegado" >';
            }
            else {
                html += '<div id="causaDenegado" class="ocultar">';
            }

            html += '<label for="causa">SELECCIONAR CAUSA</label><br>';
            html += '<select id="causa" name="causa" class="form-control" >';
            html += '<option value="NO CUMPLE CON EL 50% DEL CAPITAL ADEUDADO.">No cumple con el 50% capital adeudado</option>';
            html += '<option value="SE ENCUENTRA INHABILITADO EN ROJO.">Se encuentra en rojo</option>';
            html += '<option value="NO CUMPLE CON EL MÍNIMO DE ANTIGÜEDAD REQUERIDA.">No cumple con la antigüedad</option>';
            html += '<option value="POSEE UNA REFINANCIACIÓN TOTAL DE SU DEUDA QUE LO INHABILITA.">Tiene refinanciación total</option>';
            html += '</select>';
            html += '</div>';

            html += '<?php echo $this->tag->endForm() ?>';
            html += '</div>';//col
            html += '</div>';//fin row

            $("#onclickBtn").attr("onclick", "crudPhalcon.editPost()").text("Guardar").show();
            $("#modalCrudPhalcon .modal-body ").html(html);
            $("#modalCrudPhalcon").modal("show");
        }

        crudPhalcon.edit = function (post) {
            var json = crudPhalcon.parse(post);
            if (json.solicitudTurno_estado == "PENDIENTE") {
                //Control de Concurrencia
                var datos = {'solicitudTurno_id': json.solicitudTurno_id};
                $.ajax({
                    type: 'POST',
                    url: '/impsweb/turnos/atenderSolicitudAjax',
                    data: datos,
                    dataType: 'json',
                    encode: true
                })
                        .done(function (data) {
                            console.log(data);
                            if (!data.success) {
                                alert(data.mensaje);
                            } else {
                                //armarModal(json);
                            }
                            myTimer();
                        })
                        .fail(function (data) {
                            console.log(data);
                        });
                //Fin: Control de Concurrencia
            }else
            {
                armarModal(json);
            }
        },
            // Evento onChange del select estado.
                crudPhalcon.habilitarDeshabilitarSegunElEstado = function () {
                    //Si esta autorizado puede modificar todos los campos, el div editor debe aparecer.
                    var solicitudTurno_estado = document.getElementById("solicitudTurno_estado");
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
            //hacemos la petición ajax para editar una solicitud
                crudPhalcon.editPost = function ()//procesamos la edición
                {
                    $.ajax({
                        url: "<?php echo $this->url->get('turnos/editarSolcitudAjax') ?>",
                        data: $("#form").serialize(),
                        method: "POST",
                        success: function (data) {
                            $('#solicitudes').load(document.URL + ' #solicitudes');
                            $("#modalCrudPhalcon .modal-body").html("").html(
                                    "<p >La solicitud se edito correctamente.</p>"
                            );
                            $("#onclickBtn").hide();
                            $("#modalCrudPhalcon").hide();

                            //console.log( data);//BORRAR EN PRODUCCION
                        },
                        error: function (error) {
                            alert(error.statusText);
                            //console.log(error);//BORRAR EN PRODUCCION
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

    function mensaje() {
        alert('Solo el usuario que esta revisando la solicitud puede modificar el estado de la misma.');
    }

</script>

<!-- VEntana modal de bootstrap que utilizaremos para editar -->
<div class="modal fade" id="modalCrudPhalcon" tabindex="-1" role="dialog"
     aria-labelledby="modalCrudPhalconLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header-turnos">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>

            <div class="modal-body modal-body-gris">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-md-offset-3 ">

                    </div>
                </div>
            </div>
            <div class="modal-footer-turnos">
                <button type="button" id="onclickBtn" class="btn btn-primary btn-lg">Guardar</button>
                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>











