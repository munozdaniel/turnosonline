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

            <div class="col-lg-16 col-md-16 table-responsive">

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
                    <br>
                    <span class="fuente-16"><strong>CANTIDAD DE SOLICITUDES
                            AUTORIZADAS:</strong> {{ autorizadosEnviados }}</span>
                    <br>
                    <span class="fuente-16"><strong>CANTIDAD DE TURNOS:</strong> {{ cantidadDeTurnos }}</span>

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
                            <td width="7%"><!--en el evento onclick pasamos el post en formato json-->
                                <!--en el evento onclick pasamos el post en formato json-->
                                <a href="#" class="btn btn-info editar"
                                   onclick="crudPhalcon.edit('<?php echo htmlentities(json_encode($item)) ?>')">
                                    Editar
                                </a>
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
    <!-- Modal Info Optica -->
    <div id="info-optica" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Óptica y Contactología</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-green btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin: Modal Info Optica -->
    <script type="text/javascript">
        //objeto javascript al que le añadimos toda la funcionalidad del crud
        var crudPhalcon = {};
        $(document).ready(function () {
            //mostramos la modal para editar un post con sus datos
            crudPhalcon.edit = function (post) {
                //en post tenemos todos los datos del post parseado
                var json = crudPhalcon.parse(post), html = "";
                $("#modalCrudPhalcon .modal-title").html("LEGAJO: " + json.solicitudTurno_legajo + " - " + json.solicitudTurno_nomApe);
                /*============================ ESTADOS =============================*/

                var cantidadDeTurnos = {{ cantidadDeTurnos }},
                        autorizadosEnviados = {{ autorizadosEnviados }};

                //Creacion de las lista de estados.
                var listaUno    = ['PENDIENTE'];
                var listaDos    = ['PENDIENTE', 'REVISION'];
                var listaTres   = ['PENDIENTE', 'REVISION', 'AUTORIZADO', 'DENEGADO', 'DENEGADO POR FALTA DE TURNOS'];
                var listaCuatro = ['DENEGADO POR FALTA DE TURNOS'];
                var lista, editable = true;
                //Verificamos si se acabaron los turnos
                if ((autorizadosEnviados > 0) && (autorizadosEnviados == cantidadDeTurnos)) {
                    lista = listaCuatro;
                    editable =false;
                } else {
                    if (json.solicitudTurno_estado == "PENDIENTE") {
                        lista = listaDos;
                    }
                    else {
                        if (json.solicitudTurno_estado == "REVISION" || json.solicitudTurno_estado == "AUTORIZADO" || json.solicitudTurno_estado == "DENEGADO" ||
                                json.solicitudTurno_estado == "DENEGADO POR FALTA DE TURNOS") {
                            lista = listaTres;
                        } else {
                            if (json.solicitudTurno_estado != 'PENDIENTE' || json.solicitudTurno_estado != 'REVISION'
                                    || json.solicitudTurno_estado != 'AUTORIZADO' || json.solicitudTurno_estado != 'DENEGADO') {
                                lista = listaUno ;
                            }
                        }
                    }
                }

                //Creacion del div que contiene el select de los estados.
                var div = document.createElement("div");
                div.setAttribute("id","Estados");
                var selectList = document.createElement("select");
                selectList.setAttribute("id", "solicitudTurno_estado");
                selectList.setAttribute("style", "width:100%;");
                div.appendChild(selectList);
                //document.body.appendChild(div);
                //Agrego los elementos al select
                for (var i = 0; i < lista.length; i++) {
                    var option = document.createElement("option");
                    option.setAttribute("value", lista[i]);
                    option.text = lista[i];
                    //Pregunto si es el estado anterior para que quede seleccionado.
                    if(lista[i]==json.solicitudTurno_estado)
                        option.setAttribute("selected","true");
                    selectList.appendChild(option);
                }
                //FORMULARIO
                html += '<div class="row formulario-turnos" style="padding: 20px;">'
                html += '<?php echo $this->tag->form(array("index/edit", "method" => "post", "id" => "form")); ?>';
                //Agrego el div creado con el select al modal.
                html += '<div><label for="solicitudTurno_estado"> ESTADO </label></div>';
                html += div.innerHTML;//Muestra el codigo html.
               /*=========================================================*/
                if(editable) {
                    if (json.solicitudTurno_estado == "AUTORIZADO") {
                        html += '<div> <label>Monto Máximo</label>';
                        html += '<input type="text" name="solicitudTurno_montoMaximo" value="' + json.solicitudTurno_montoMax + '" class="form-control"></div>';
                        html += '<div> <label>Monto Posible</label>';
                        html += '<input type="text" name="solicitudTurno_montoPosible" value="' + json.solicitudTurno_montoPosible + '" class="form-control"></div>';
                        html += '<div> <label>Cantidad de Cuotas</label>';
                        html += '<input type="text" name="solicitudTurno_cantCuotas" value="' + json.solicitudTurno_cantCuotas + '" class="form-control"></div>';
                        html += '<div> <label>Valor de las Cuotas</label>';
                        html += '<input type="text" name="solicitudTurno_valorCuota" value="' + json.solicitudTurno_valorCuota + '" class="form-control"></div>';
                        html += '<div> <label>Observaciones</label>';
                        html += '<textarea class="form-control" name="content" rows="3">' + json.solicitudTurno_observaciones + '</textarea>';
                    }
                }                html += '<?php echo $this->tag->endForm() ?>';
                html+='</div>';
                $("#onclickBtn").attr("onclick", "crudPhalcon.editPost()").text("Editar").show();
                $("#modalCrudPhalcon .cuerpo-modal ").html(html);
                $("#modalCrudPhalcon").modal("show");
            },


                //hacemos la petición ajax para editar un post
                    crudPhalcon.editPost = function ()//procesamos la edición
                    {
                        $.ajax({
                            url: "<?php echo $this->url->get('index/edit') ?>",
                            data: $("#form").serialize(),
                            method: "POST",
                            success: function (data) {
                                alert("cerrabdi");
                                $("#modalCrudPhalcon .modal-body").html("").html(
                                        "<p >Post actualizado correctamente.</p>"
                                );
                                $("#onclickBtn").hide();
                            },
                            error: function (error) {
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










