<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>{{ titulo }}</ins>
                    <br>
                </h1>

                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-home '></i> INICIO",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="left">
                <div class="row">
                    <div class="col-md-4">
                        {{ image('img/turnos/infoturno.png','alt':'turnos online informacion','width':'100%  ','style':"margin-top:2em;") }}
                        {% if solicitud_id is defined %}
                            {{ hidden_field('solicitud_id','value':solicitud_id,'form':'form_comprobante') }}
                        {% endif %}
                    </div>
                    <div class="col-md-4" style="border-left:2px solid #1E90FF; border-right:2px solid #1E90FF; ">
                        {% if legajo is defined %}
                            <label for="legajo" class="control-label">
                                <strong style="color: red">*</strong> Legajo:</label>
                            <input type="number" id="legajo" name="legajo"
                                   class="form-control user-error"
                                   style="text-align:center !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL LEGAJO" required="true" autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ legajo }}">
                            <hr>
                        {% endif %}
                        {% if apeNom is defined %}
                            <label for="nombre" class="control-label">
                                <strong style="color: red">*</strong> Apellido y Nombre:</label>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control user-error"
                                   style="text-align:center !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL APELLIDO Y EL NOMBRE" required="true"
                                   autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ apeNom }}">
                            <hr>
                        {% endif %}
                        {% if codigo is defined %}
                            <label for="codigo" class="control-label">
                                <strong style="color: red">*</strong> Código de Operación:</label>
                            <input type="text" id="codigo" name="codigo"
                                   class="form-control user-error"
                                   style="text-align:center !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL CODIGO" required="true" autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ codigo }}">
                        {% endif %}
                    </div>
                    <div  id="administracion">

                    <div class="col-md-4">
                        {% if solicitud_id is defined %}

                            {% if pendiente is defined %}
                                <a id="confimar_asistencia_btn" data-toggle="modal"
                                   data-target="#confirmarAsistencia" class='btn btn-info btn-lg btn-block'><i
                                            class='fa fa-check-circle'></i> CONFIRMAR ASISTENCIA</a>
                            {% endif %}
                            {% if confirmado is defined %}

                                {{ form('turnos/comprobanteTurnoPost','method':'POST', 'id':'form_comprobante') }}


                                <button id="imprimir_comprobante_btn" type='submit' class='btn btn-info btn-lg btn-block' formtarget='_blank'><i
                                            class='fa fa-print' style=""></i> IMPRIMIR COMPROBANTE
                                </button>
                                {{ end_form() }}
                            {% endif %}
                            <div style="">
                                <a data-toggle="modal"
                                   data-target="#cancelarAsistencia" class='btn btn-danger btn-lg btn-block'><i
                                            class='fa fa-remove'></i> CANCELAR ASISTENCIA </a>
                            </div>
                        {% endif %}
                        </div>
                    </div>
                    <div class="col-md-12" align="center">
                        <hr>
                        <h3><em>Muchas gracias por utilizar nuestros servicios</em></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancelarAsistencia" role="dialog">
        <div class="modal-dialog modal-sm"
             style="width:550px !important; border: 0;border-top: 5px solid #5BC0DE;box-shadow: 0 2px 10px rgba(0,0,0,0.8);">
            <div class="modal-content" align="center" style="border-radius: 0;">

                <a class="btn btn-lg btn-warning ">
                    <i class="fa fa-warning fa-3x"></i> </a>

                <div class="modal-body" align="center">
                    <div class="ocultar_proximo">
                    <h3>Está seguro de cancelar su asistencia? </h3>
                    <h4>Una vez cancelado no podrá volver a reactivar su asistencia, deberá solicitar un nuevo
                        turno.</h4>
                    <a class="btn btn-danger btn-lg" onclick="cancelarAsistencia()" style="font-size: large;">SI</a>
                    </div>
                    <div id="mensaje_resultado" ></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmarAsistencia" role="dialog">
        <div class="modal-dialog modal-sm"
             style="width:550px !important; border: 0;border-top: 5px solid #5BC0DE;box-shadow: 0 2px 10px rgba(0,0,0,0.8);">
            <div class="modal-content" align="center" style="border-radius: 0;">

                <a class="btn btn-lg btn-success ">
                    <i class="fa fa-question-circle fa-3x"></i> </a>

                <div  class="modal-body" align="center">
                    <div class="ocultar_proximo">
                    <h3>Está seguro de confirmar su asistencia?</h3>
                    <h4>Una vez que confirmado podrá imprimir un comprobante con los datos para asistir a nuestra
                        sucursal.</h4>
                    </div>
                    <a id="confirmar_btn" class="btn btn-info btn-lg ocultar_proximo" onclick="confirmarAsistencia()">SI</a>
                    <div id="mensaje_resultado_confirmar" class="modal-body" align="center"></div>
                    {{ form('turnos/comprobanteTurnoPost','method':'POST', 'id':'form_comprobante_confirmar','class':'ocultar') }}
                    <div class="bs-callout bs-callout-danger" align="left">
                        <h3 class="font-azul"><i class="fa fa-warning"></i>
                            <ins>IMPORTANTE</ins>
                            , LEA LAS SIGUIENTES INSTRUCCIONES PARA SER ATENDIDO
                        </h3>
                        <p style="font-size: medium">A continuación se muestran las <strong class="strong-azul">
                                fechas de atención</strong> y un <strong class="strong-azul">código de
                                turno</strong>.
                            <br>
                            1. Las <strong class="strong-azul"> fechas de atención</strong> le indicará cuando
                            podrá acercarse a nuestras oficinas para comenzar con los trámites del préstamo
                            personal.
                            <br>
                            2. El <strong class="strong-azul">código de turno</strong> es muy importante que lo
                            guarde porque deberá ingresarlo en la terminal de autoconsulta para que pueda ser
                            atendido.
                            <br>
                            3. Opcionalmente, puede guardar o imprimir el comprobante.
                        </p>
                    </div>
                    {{ hidden_field("solicitud_id",'class':'comprobanteConfirmar_id') }}
                    <button type='submit' class='btn btn-info btn-lg btn-block' formtarget='_blank'>
                        <i class='fa fa-print' style=""></i> IMPRIMIR COMPROBANTE
                    </button>
                    {{ end_form() }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function cancelarAsistencia() {
        $('.alerta_mensaje').remove();
        $('#mensaje_resultado').append('<div class="alerta_mensaje" align="center>' +
        '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>  Procesando...</div>');
        $("#modal_resultado").modal();
        datos = {
            'solicitudTurno_id': $('#solicitud_id').val()
        };
        //==========
        $.ajax({
            type: 'POST',
            url: '/impsweb/solicitudTurno/cancelaAsistenciaAjax',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    //console.log(data);
                    $('.alerta_mensaje').remove();
                    if (!data.success) {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje"><h3 class="alert alert-danger">' + data.mensaje + '</h3></div>');
                    } else {
                        $(".ocultar_proximo").hide();//ocultamos el boton SI

                        $('#mensaje_resultado').append('<div class="alerta_mensaje">' +
                        '<h3 class="alert alert-success"> El turno ha sido cancelado correctamente <hr>' +
                        ' <small>' + data.mensaje + '</small>' +
                        '</h3>' +
                        '<p><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>' +
                        '<span class="sr-only">Loading...</span>Redireccionando a la página inicial...</p> </div>');

                        setTimeout(redireccionar,8000)
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
    }
    function confirmarAsistencia() {
        $('.alerta_mensaje').remove();
        $('#mensaje_resultado_confirmar').append('<div class="alerta_mensaje" align="center>' +
        '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>  Procesando...</div>');
        $("#modal_resultado").modal();
        datos = {
            'solicitudTurno_id': $('#solicitud_id').val()
        };
        //==========
        $.ajax({
            type: 'POST',
            url: '/impsweb/solicitudTurno/aceptaAsistenciaAjax',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    //console.log(data);
                    $('.alerta_mensaje').remove();
                    if (!data.success) {
                        $('#mensaje_resultado_confirmar').append('<div class="alerta_mensaje"><h3 class="alert alert-danger">' + data.mensaje + '</h3></div>');
                    } else {
                        $('#mensaje_resultado_confirmar').append('<div class="alerta_mensaje">' +
                        '<h3 class="alert alert-success"> El turno ha sido confirmado correctamente</h3> ' +
                        '<hr>' +
                        '<h3> <div style="text-align: left; font-size: 17px; margin-left: 2em;">' + data.mensaje + '</small></h3>' +
                        '</div>');
                        $(".ocultar_proximo").hide();//ocultamos el boton SI
                        $(".comprobanteConfirmar_id").val($('#solicitud_id').val());//seteamos el id para el form del modal
                        $("#form_comprobante_confirmar").delay(100).fadeIn(500);//Muestra el boton imprimir comprobante en el modal
                        $('a#confimar_asistencia_btn').text('Ver Comprobante');//Cambia el texto del btn
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
    }

    function redireccionar() {
        window.location = "/impsweb/index";
    }
</script>