<style>
    a {
        color: #2da2c8
    }

    .heading h2 {
        font-size: 30px;
        line-height: 35px;
    }

    .th-estilo {
        text-align: center;
        color: white;
        background-color: #006688;
    }

    .td-estilo {
        text-align: center;
        width: 180px
    }

    .td-observaciones {
        max-width: 180px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
</style>
<section id="onepage" class="admin bg_line">
    <div align="center">
        <div class="curriculum-bg-header modal-header " align="left">
            <h1>
                <ins>LISTA DE TURNOS SOLICITADOS</ins>
                <br>
            </h1>
            <h3>
                <small><em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos afiliados
                        que han solicitado un turno.</em></small>
            </h3>
            <table class="" width="100%">
                <tr>
                    <td align="right">{{ link_to("administrar", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary') }}</td>
                </tr>
            </table>

        </div>
    </div>
    <hr>
    <div class="row form-blanco borde-top borde-left-4 borde-right-4">
        {% if informacion is defined %}
            <div class="col-sm-4" align="right">
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
                        <ins>DÍA DE ATENCI&Oacute;N</ins>
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
        </div>
        <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="th-estilo">Legajo</th>
                    <th class="th-estilo">Apellido y nombre</th>
                    <th class="th-estilo">Fecha solicitud</th>
                    <th class="th-estilo">Estado</th>
                    <th class="th-estilo">Monto maximo</th>
                    <th class="th-estilo">Monto posible</th>
                    <th class="th-estilo">Máximo de cuotas</th>
                    <th class="th-estilo">Valor cuota</th>
                    <th class="th-estilo">Observaciones</th>
                    <th class="th-estilo">Fecha revisión</th>
                    <th class="th-estilo">Empleado</th>
                    <th class="th-estilo">Tipo</th>
                    <th class="th-estilo">EDITAR</th>
                </tr>
                </thead>
                <tbody>

                {% for item in page.items %}
                    <tr>
                        <td class="td-estilo">{{ item.getSolicitudTurnoLegajo() }}</td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoNomApe() }}</td>
                        <td class="td-estilo">
                            {{ date('d/m/Y',(item.getSolicitudTurnoFechaPedido()) | strtotime) }}
                        </td>
                        <td class="td-estilo"><strong><a
                                        class="btn btn-block "> {{ item.getSolicitudTurnoEstado() }}</a></strong>
                        </td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoMontoMax() }}</td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoMontoPosible() }}</td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoCantCuotas() }}</td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoValorCuota() }}</td>
                        <td class="td-observaciones" title="{{ item.getSolicitudTurnoObservaciones() }}">
                            {{ item.getSolicitudTurnoObservaciones() }}
                        </td>
                        <td class="td-estilo">
                            {% if(item.getSolicitudTurnoFechaProcesamiento() != null) %}
                                {% set fechaModif = date('d/m/Y',(item.getSolicitudTurnoFechaProcesamiento()) | strtotime) %}
                            {% else %}
                                {% set fechaModif = '-' %}
                            {% endif %}
                            {#Mostramos la variable seteada con los valores anteriores.#}
                            {{ fechaModif }}
                        </td>
                        <td class="td-estilo">{{ item.getSolicitudTurnoNickUsuario() }}</td>
                        <td class="td-estilo">{{ item.getTipoturno().getTipoTurnoNombre() }}</td>

                        <td width="7%">
                            {% if ((item.getSolicitudTurnoNickUsuario() ==  session.get('auth')['usuario_nick'])
                            OR (session.get('auth')['rol_nombre']== "ADMIN")
                            OR (session.get('auth')['rol_nombre'] == "SUPERVISOR")) %}
                                <a class="btn btn-info editar btn-block"
                                   onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item->toArray())) ?>')">
                                    EDITAR</a>
                            {% elseif(item.getSolicitudTurnoNickUsuario() == '-') %}
                                {% if({{ informacion['cantidadAutorizados'] }} < {{ informacion['cantidadTurnos'] }}) %}
                                    <a class="btn btn-info editar btn-block"
                                       onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item->toArray())) ?>')">
                                        EDITAR</a>
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
            <div align="center"
                 style="width:50%;position:fixed;bottom:0;border-top:#2AA0C7 2px;left:0;background-color:#2AA0C7; padding: 4px 0 0 0;"
                 class=" col-xs-12 col-sm-12 col-md-5 col-md-offset-3">
                {{ submit_button('ENVIAR RESPUESTAS A LOS AFILIADOS','class':'btn btn-blue btn-lg btn-block') }}
            </div>
        </div>

        {{ end_form() }}
    </div>
</section>
<!-- ====================================== -->

<script type="text/javascript">
    $(".problema").fadeTo(4000, 500).slideUp(500, function () {
        $(".problema").alert('close');
    });
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);

    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
        $('#solicitudes').load(document.URL + ' #solicitudes');
    }

    //objeto javascript al que le añadimos toda la funcionalidad del crud
    var crudPhalcon = {};

    $(document).ready(function () {
        //mostramos la modal para editar un post con sus datos
        crudPhalcon.edit = function (post) {
            //en post tenemos todos los datos del post parseado
            var json = crudPhalcon.parse(post), html = "";
            console.log(json);
            $("#modalCrudPhalcon .modal-title").html("<strong>" + json.solicitudTurno_legajo + "</strong> |   <strong>NOMBRE:</strong> " + json.solicitudTurno_nomApe + " <strong> ESTADO: </strong> " + json.solicitudTurno_estado);


            /*============================ VERIFICANDO EN QUE ESTADO SE ENCUENTRA PARA ARMAR LA LISTA ============*/
            var limpiarForm = false;
            var lista, editable = false, autorizacion = false;
            var autorizadosEnviados =  {{ informacion['autorizadosEnviados'] }};
            var sinTurnos = false;
            var turnosAutorizados = document.getElementById("cantidadAutorizados").value;
            var cantidadDeTurnos = document.getElementById("cantidadTurnos").value;
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

            html += '<div> <label for="solicitudTurno_montoMax">Monto Máximo</label>';
            html += '<input type="number" min="0" id="solicitudTurno_montoMax" name="solicitudTurno_montoMax"  required="true" title="Ingrese numeros únicamente" placeholder="INGRESE EL MONTO MÁXIMO"  value="' + json.solicitudTurno_montoMax + '" class="form-control"></div>';
            html += '<div> <label for="solicitudTurno_montoPosible">Monto Posible</label>';
            html += '<input type="number" min="0" id="solicitudTurno_montoPosible" name="solicitudTurno_montoPosible"   title="Ingrese numeros unicamente" placeholder="INGRESE EL MONTO POSIBLE" required="true" value="' + json.solicitudTurno_montoPosible + '" class="form-control"></div>';
            html += '<div> <label for="solicitudTurno_cantCuotas">Máximo de Cuotas</label>';
            html += '<input type="number" min="0" id="solicitudTurno_cantCuotas" name="solicitudTurno_cantCuotas"  required="true"  title="Ingrese numeros unicamente" placeholder="INGRESE LA CANTIDAD DE CUOTAS" value="' + json.solicitudTurno_cantCuotas + '" class="form-control"></div>';
            html += '<div> <label for="solicitudTurno_valorCuota">Valor de las Cuotas</label>';
            html += '<input type="number" min="0" id="solicitudTurno_valorCuota" name="solicitudTurno_valorCuota"  required="true"  title="Ingrese numeros unicamente" placeholder="INGRESE EL VALOR DE LAS CUOTAS" value="' + json.solicitudTurno_valorCuota + '" class="form-control"></div>';
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
            html += '<option value="NO CUMPLE CON EL 50% DEL CAPITAL ADEUDADO">No cumple con el 50% capital adeudado</option>';
            html += '<option value="SE ENCUENTRA EN ROJO">Se encuentra en rojo</option>';
            html += '<option value="NO CUMPLE CON LA ANTIGUEDAD">No cumple con la antiguedad</option>';
            html += '<option value="REFINANCIACION TOTAL">Tiene refinanciación total</option>';
            html += '</select>';
            html += '</div>';

            html += '<?php echo $this->tag->endForm() ?>';
            html += '</div>';//col
            html += '</div>';//fin row

            $("#onclickBtn").attr("onclick", "crudPhalcon.editPost()").text("Guardar").show();
            $("#modalCrudPhalcon .modal-body ").html(html);
            $("#modalCrudPhalcon").modal("show");
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
                        url: "<?php echo $this->url->get('turnos/edit') ?>",
                        data: $("#form").serialize(),
                        method: "POST",
                        success: function (data) {
                            $('#solicitudes').load(document.URL + ' #solicitudes');
                            $("#modalCrudPhalcon .modal-body").html("").html(
                                    "<p >La solicitud se edito correctamente.</p>"
                            );
                            $("#onclickBtn").hide();
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











