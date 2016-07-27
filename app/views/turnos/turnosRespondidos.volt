<style>

    .heading h2 {
        font-size: 30px;
        line-height: 35px;
    }

    .th-titulo {
        vertical-align: middle !important;
    }

    .alert-info{background-color:indianred;border:solid red;width:900px;text-align: center;margin-left: 20%;}

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
                    <small> <em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos afiliados
                            a los cuales se les envio la respuesta a su solicitud con Autorizado/Denegado.</em></small>
                </h3>

            </div>
        </div>

    </div>

    <hr>

    <div class="col-md-12">
        {{ content() }}
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

            <div class="col-sm-12" align="center">

                <hr>

                <div class=" col-sm-2 col-sm-offset-4">
                    <div class="cuadrado-azul" style="background-color: #5bc0de;"><i class="fa fa-bookmark"></i></div>
                    <strong>ONLINE</strong>
                </div>

                <div class=" col-sm-2">
                    <div class="cuadrado-verde" style="background-color: #5cb85c;"><i class="fa fa-bookmark"></i></div>
                    <strong>TERMINAL</strong>
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
                        <th class="th-titulo">Estado Asistencia ID</th>{# 1: Online o Terminal #}
                        <th class="th-titulo">Afiliado</th>{# 2: Legajo y Nombre #}
                        <th class="th-titulo">Email/Telefono</th>{# 3 #}
                        <th class="th-titulo">Fecha respuesta enviada</th>{# 4 #}
                        <th class="th-titulo">Usuario</th>{# 5 #}
                        <th class="th-titulo">Estado</th>{# 6 Estado de Deuda: Autorizado - Denegado - Denegado por Falta de Turno#}
                        <th class="th-titulo">Observación</th>{# 7 #}
                        <th class="th-titulo">Código</th>{# 8 #}
                        <th class="th-titulo">Estado de asistencia</th>{# 9 En espera - Confirmado - Plazo vencido - cancelado (fondo bordo)#}
                        <th class="th-titulo" style="width: 120px"><i class="fa fa-calendar fa-2x  "></i> Asiste</th>{# 10 : Botones para aceptar/cancelar Asistencia #}
                        <th class="th-titulo">Ver Comprobante</th>{# 11 #}
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="modal_resultado" role="dialog">
    <div class="modal-dialog modal-sm"
         style="width:550px !important; border: 0;border-top: 5px solid #5BC0DE;box-shadow: 0 2px 10px rgba(0,0,0,0.8);">
        <div class="modal-content" align="center" style="border-radius: 0px;">

            <a class="btn btn-lg btn-info ">
                <i class="fa fa-info-circle fa-2x"></i> Información</a>

            <div id="mensaje_resultado" class="modal-body" align="left">
                <div class="alerta_mensaje"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<script>
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);

    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
    }

    $(".alert-info").fadeTo(4000, 500).slideUp(500, function () {
        $(".alert-info").alert('close');
    });

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
                    exportOptions: {columns:[2, 3, 4, 5, 6, 7, 8, 11]}
                }
            ],
            "columnDefs": [
                {
                    "targets": [0, 1],
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
                if (aData[6] != "AUTORIZADO") {//ESTADO
                    $nRow.css({"color": "red"});
                }
                if (aData[1] == 4) {// SI EL ESTADO ASISTENCIA ES CANCELADO
                    $nRow.css({"color": "white"});
                    $nRow.css({"background-color": "#4A0D0D"});
                }

            }
        });
        var myVar = setInterval(function () {
            myTimer()
        }, 220000);

        function myTimer() {
          //  tabla.ajax.reload();
            tabla.ajax.reload( null, false ); // user paging is not reset on reload

        }

        var cuerpoTabla = $('#tabla tbody');
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
        });
    });

</script>
