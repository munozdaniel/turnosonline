<style>

    .heading h2 {
        font-size: 30px;
        line-height: 35px;
    }

    .th-titulo {
        vertical-align: middle !important;
    }

    /* Preloader enviar respuestas*/
    #loader_bg {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.26); /* change if the mask should have another color then white */
        z-index: 99999; /* makes sure it stays on top */
    }

    #loader_gif {
        width: 200px;
        height: 200px;
        position: absolute;
        left: 50%; /* centers the loading animation horizontally one the screen */
        top: 50%; /* centers the loading animation vertically one the screen */
        background-image: url(../img/turnos/loading_bar.gif); /* path to your loading animation */
        background-repeat: no-repeat;
        background-position: center;
        margin: -100px 0 0 -100px; /* is width and height divided by two */
    }
</style>

<section id="onepage" class="admin bg_line">
    <div class="container">

        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>LISTA DE TURNOS RESPONDIDOS</ins>
                    {{ link_to("administrar", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary','style':'margin-left:33%;background-color:#195889;') }}
                    <br>
                </h1>

                <h3>
                    <small><em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos
                            afiliados
                            a los cuales se les envio la respuesta a su solicitud con Autorizado/Denegado.</em></small>
                </h3>

            </div>
        </div>



    <hr>

    <div class="col-md-12">
        {{ content() }}
    </div>
    <div id="loader_bg" style="display: none;" align="center">
        <div id="loader_gif" style="display: none;">&nbsp;</div>
        <p class="loader_text pulse1">ENVIANDO</p>
    </div>
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
                    Desde {{ informacion['diaAtencion'] }}<br/>
                    Hasta {{ informacion['diaAtencionFinal'] }}
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
                        Total: {{ informacion['cantidadTurnos'] }}<br/>
                        Autorizados: {{ informacion['cantidadAutorizados'] }}
                    </h4>
                </div>
            </div>
        {% endif %}

    </div>

    <div class="row form-blanco borde-top borde-left-4 borde-right-4">

        <br/>

        <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
            <table id="tabla" class="table_r table-striped table-bordered table-condensed">
                <thead style="background-color: #131313;">
                <tr>
                    <th class="th-titulo">ID</th>{# 0 #}
                    <th class="th-titulo">Tipo de Turno</th>{# 1: Online o Terminal #}
                    <th class="th-titulo">Legajo</th>{# 2: Legajo y Nombre #}
                    <th class="th-titulo">Apellido y Nombre</th>{# 3 #}
                    <th class="th-titulo">Email</th>{# 4 #}
                    <th class="th-titulo">Teléfono</th> {# 5 #}
                    <th class="th-titulo">Estado</th>{# 6 #}
                    <th class="th-titulo">Estado para busquedas</th>{# 7 #}
                    <th class="th-titulo">Estado Asistencia</th>{# 8 #}
                </tr>
                </thead>
            </table>
        </div>

    </div>
    </div>
</section>


<div id="verDatos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="col-lg-12">
            <div class="panel panel-yellow" style="background-color: rgb(255, 255, 255);">
                <div class="panel-heading">Detalles
                    <a class="btn btn-default btn-lg pull-right" data-dismiss="modal"><i
                                class="fa fa-2x fa-remove "></i></a>
                </div>
                <div class="panel-body pan">
                    <form action="#" class="form-horizontal">
                        <div class="row">
                            <div id="mensaje_resultado" class="col-md-6 col-md-offset-3 modal-body" align="center">
                                <div class="alerta_mensaje"></div>
                            </div>
                        </div>  
                        <div class="form-body pal"><h3>Afiliado</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_legajo" class="col-md-3 control-label">Legajo</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_legajo','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_nomApe" class="col-md-3 control-label">Apellido y
                                            Nombre</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_nomApe','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_documento"
                                               class="col-md-3 control-label">Documento</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_documento','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_email" class="col-md-3 control-label">Email</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_email','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_numTelefono"
                                               class="col-md-3 control-label">Teléfono</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_numTelefono','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_fechaPedido" class="col-md-3 control-label">Fecha
                                            Pedido</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_fechaPedido','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Turno Solicitado</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_tipo" class="col-md-3 control-label">Tipo de
                                            Turno</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_tipo','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_codigo" class="col-md-3 control-label">Código</label>
                                        <div class="col-md-4">
                                            {{ text_field('solicitudTurno_codigo','class':'form-control bg-info','readOnly':'true','placeholder':'SIN ESPECIFICAR','style':'border:3px solid #000;') }}
                                        </div>
                                            <div id="accion_imprimir" class="col-md-5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_estado" class="col-md-3 control-label">Estado</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_estado','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_estadoAsistencia" class="col-md-3 control-label">Estado
                                            de Asistencia</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_estadoAsistencia','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_causa" class="col-md-3 control-label">Causa de
                                            Denegado</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_causa','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="solicitudTurno_observacion" class="col-md-3 control-label">Observación</label>

                                        <div class="col-md-9">
                                            {{ text_field('solicitudTurno_observacion','class':'form-control','readOnly':'true','placeholder':'SIN ESPECIFICAR') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div id="accion_asistencia" class="col-md-6">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function verDatos(solicitudTurno_id) {
        $('#loader_gif').fadeIn();
        $('#loader_bg').delay(100).fadeIn('slow');
        var datos = {'solicitudTurno_id': solicitudTurno_id};
        $.ajax({
            type: 'POST',
            url: '/impsweb/turnos/buscarSolicitudAjax',
            dataType: 'json',
            data: datos,
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    $('.alerta_mensaje').remove();
                    $(".div_dinamico").remove();
                    if (!data.success) {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-danger alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<h3><strong>Advertencia!</strong></h3><hr>' + data.mensaje + '</div>');
                    } else {
                        var solicitud = data.solicitud;
                        $("#solicitudTurno_legajo").val(solicitud['solicitudTurno_legajo']);
                        $("#solicitudTurno_nomApe").val(solicitud['solicitudTurno_nomApe']);
                        $("#solicitudTurno_documento").val(solicitud['solicitudTurno_documento']);
                        $("#solicitudTurno_email").val(solicitud['solicitudTurno_email']);
                        $("#solicitudTurno_fechaPedido").val(solicitud['solicitudTurno_fechaPedido']);
                        $("#solicitudTurno_codigo").val(solicitud['solicitudTurno_codigo']);
                        $("#solicitudTurno_tipo").val(solicitud['solicitudTurno_tipo']);
                        $("#solicitudTurno_estado").val(solicitud['solicitudTurno_estado']);
                        $("#solicitudTurno_estadoAsistencia").val(solicitud['solicitudTurno_estadoAsistencia']);
                        $("#solicitudTurno_causa").val(solicitud['solicitudTurno_causa']);
                        $("#solicitudTurno_observacion").val(solicitud['solicitudTurno_observacion']);
                        var div_accion =  $("#accion_asistencia");
                        div_accion.append('<div class="div_dinamico form-group">'+solicitud['denegar']+solicitud['confirmar']+'</div>');
                        var div_imprimir = $("#accion_imprimir");
                        div_imprimir .append('<div class="div_dinamico">'+solicitud['comprobante']+'</div>');

                    }
                    $('#verDatos').modal('show');


                })
                .fail(function (data) {
                    console.log(data);
                })
                .always(function (data) {
                    console.log(data);
                    $('#loader_gif').fadeOut();
                    $('#loader_bg').delay(100).fadeOut('slow');
                });
    }
    /*Confirmar Asistencia*/
    function confirmarAsistencia(solicitudTurno_id)
    {
        $('.alerta_mensaje').remove();
        $('#mensaje_resultado').append('<div class="alerta_mensaje" align="center">' +
        '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span> Procesando...</div>');
        var datos = {
            'solicitudTurno_id': solicitudTurno_id
        };
        //==========
        $.ajax({
            type: 'POST',
            url: '/impsweb/solicitudTurno/aceptaAsistenciaTablaAjax',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    $(".div_dinamico").remove();

                    $('.alerta_mensaje').remove();
                    if (!data.success) {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje">' + data.mensaje + '</div>');
                    } else {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-success">' +
                        'El turno ha sido <strong>confirmado</strong> correctamente');
                        var solicitud = data.solicitud;
                        $("#solicitudTurno_codigo").val(solicitud['solicitudTurno_codigo']);
                        $("#solicitudTurno_estadoAsistencia").val(solicitud['solicitudTurno_estadoAsistencia']);
                        var div_accion =  $("#accion_asistencia");
                        div_accion.append('<div class="div_dinamico form-group">'+solicitud['denegar']+solicitud['confirmar']+'</div>');
                        var div_imprimir = $("#accion_imprimir");
                        div_imprimir .append('<div class="div_dinamico">'+solicitud['comprobante']+'</div>');
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
    }
    /*Denegar Asistencia*/
    function denegarAsistencia(solicitudTurno_id) {
        $('.alerta_mensaje').remove();
        $('#mensaje_resultado').append('<div class="alerta_mensaje" align="center">' +
        '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span> Procesando...</div>');
        var datos = {
            'solicitudTurno_id': solicitudTurno_id
        };
        //==========
        $.ajax({
            type: 'POST',
            url: '/impsweb/solicitudTurno/cancelaAsistenciaTablaAjax',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    $(".div_dinamico").remove();

                    console.log(data);
                    $('.alerta_mensaje').remove();
                    if (!data.success) {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje">' + data.mensaje + '</div>');
                    } else {
                        $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-success"> El turno ha sido <strong>cancelado</strong> correctamente </div>');
                        var solicitud = data.solicitud;
                        $("#solicitudTurno_codigo").val(solicitud['solicitudTurno_codigo']);
                        $("#solicitudTurno_estadoAsistencia").val(solicitud['solicitudTurno_estadoAsistencia']);
                        var div_accion =  $("#accion_asistencia");
                        div_accion.append('<div class="div_dinamico form-group">'+solicitud['denegar']+solicitud['confirmar']+'</div>');
                        var div_imprimir = $("#accion_imprimir");
                        div_imprimir .append('<div class="div_dinamico">'+solicitud['comprobante']+'</div>');
                    }

                })
                .fail(function (data) {
                    console.log(data);
                });
    }

</script>
<script>
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);

    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
    }

    /* $(".alert-info").fadeTo(4000, 500).slideUp(500, function () {
     $(".alert-info").alert('close');
     });*/

    $(document).ready(function () {
        var fechaIS = '{{ informacion['fechaInicio'] }}';
        var fechaFS = '{{ informacion['fechaFinal'] }}';
        var fechaIA = '{{ informacion['diaAtencion'] }}';
        var fechaFA = '{{ informacion['diaAtencionFinal'] }}';

        var tabla = $('#tabla').DataTable({
            ajax: {
                'url': '/impsweb/turnos/turnosRespondidosAjax',
                'type': 'POST',
                dataType: 'json'
            },
            "processing": true,
            dom: 'Bfrtlip',
            buttons: [
                {
                    text: 'Recargar Tabla',
                    action: function (e, dt, node, config) {
                        tabla.ajax.reload();
                    }
                },
                {
                    text: "Exportar PDF",
                    title: "Listado de turnos",
                    message: "Periodo de solicitud: " + fechaIS + " - " + fechaFS + "   Periodo de atención: " + fechaIA + " - " + fechaFA,
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open',
                    exportOptions: {columns: [2, 3, 4, 5, 6, 8]}
                }
            ],
            "columnDefs": [
                {
                    "targets": [0, 1,7,8],
                    "visible": false,
                    "searchable": false
                }
            ],
            'pageLength': 10,
            'lengthMenu': [[10, 20, 50, 75, -1], [10, 20, 50, 75, 'Todos']],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Búsqueda General:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var $nRow = $(nRow);
                //console.log(aData[9]);
                if (aData[7] != "AUTORIZADO") {//ESTADO
                    $nRow.css({"color": "red"});
                }else
                {
                    $nRow.css({"color": "green"});
                }


            }
        });
        var myVar = setInterval(function () {
            myTimer()
        }, 220000);

        function myTimer() {
            //  tabla.ajax.reload();
            tabla.ajax.reload(null, false); // user paging is not reset on reload

        }

     /*   var cuerpoTabla = $('#tabla tbody');


        cuerpoTabla.on('dblclick', '#acepta', function () {
            $('.alerta_mensaje').remove();
            $('#mensaje_resultado').append('<div class="alerta_mensaje" align="center">' +
            '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span> Procesando...</div>');
            $("#modal_resultado").modal();
            var data = tabla.row($(this).parents('tr')).data();
            var datos = {
                'solicitudTurno_id': data[0]
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
                            $('#mensaje_resultado').append('<div class="alerta_mensaje"><h3 class="alert alert-danger">' + data.mensaje + '</h3></div>');
                        } else {
                            $('#mensaje_resultado').append('<div class="alerta_mensaje alert alert-success">' +
                            '<h3> El turno ha sido <strong>confirmado</strong> correctamente' +
                            ' <hr>' +
                            ' </h3><h4>' + data.mensaje + '</small></h4></div>');
                        }
                        tabla.ajax.reload();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });
        });
        cuerpoTabla.on('dblclick', '#cancela', function () {
            $('.alerta_mensaje').remove();
            $('#mensaje_resultado').append('<div class="alerta_mensaje" align="center>' +
            '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>  Procesando...</div>');
            $("#modal_resultado").modal();
            var data = tabla.row($(this).parents('tr')).data();
            var datos = {
                'solicitudTurno_id': data[0]
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
                            $('#mensaje_resultado').append('<div class="alerta_mensaje"><h3 class="alert alert-success"> El turno ha sido <strong>cancelado</strong> correctamente <hr> <small>' + data.mensaje + '</small></h3></div>');
                        }
                        tabla.ajax.reload();

                    })
                    .fail(function (data) {
                        console.log(data);
                    });
        });*/
    });

</script>
