<style>

    .heading h2 {
        font-size: 30px;
        line-height: 35px;
    }

    .th-titulo {
        vertical-align: middle !important;
    }
</style>

<section id="onepage" class="admin bg_line">
    <div align="center">
        <div class="curriculum-bg-header modal-header " align="left">
            <h1>
                <ins>LISTA DE TURNOS RESPONDIDOS</ins>
                <br>
            </h1>
            <h3>
                <small><em style=" color:#FFF !important;"> A continuación se muestra un listado de aquellos afiliados
                        con turnos Autorizado/Denegado.</em></small>
            </h3>
            <table class="" width="100%">
                <tr>
                    <td align="right">{{ link_to("administrar", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                </tr>
            </table>

        </div>
    </div>
    <hr>
    <div class="col-md-12">
        {{ content() }}
    </div>
    <div class="row form-blanco borde-top borde-left-4 borde-right-4">
        {% if informacion is defined %}
            <div class="col-sm-4" align="right">
                <h3><strong>
                        <ins>PERIODO DE TURNOS</ins>
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
            <div class="col-sm-4" align="left" {% if rojo == true %}style="color: red;"{% endif %}>
                <h3>
                    <strong>
                        <ins>TURNOS</ins>
                    </strong>
                </h3>
                <h4>
                    Total: {{ informacion['cantidadTurnos'] }}<br>
                    Autorizados: {{ informacion['cantidadAutorizados'] }}
                </h4>
            </div>
            <div class="col-sm-12" align="center">
                <hr>

                <div class=" col-sm-2 col-sm-offset-3">

                    <div class="cuadrado-azul"><i class="fa fa-bookmark"></i></div>
                    <strong> ONLINE</strong>
                </div>
                <div class=" col-sm-2">

                    <div class="cuadrado-verde"><i class="fa fa-bookmark"></i></div>
                    <strong> TERMINAL </strong>
                </div>
                <div class=" col-sm-2">

                    <div class="cuadrado-amarillo"><i class="fa fa-bookmark"></i></div>
                    <strong> MANUALES</strong>
                </div>
            </div>

        {% endif %}

    </div>

    <div class="row form-blanco borde-top borde-left-4 borde-right-4">

        <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
            <table id="tabla" class="table_r table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="th-titulo">Codigo</th>
                    <th class="th-titulo">Legajo</th>
                    <th class="th-titulo">Apellido y nombre</th>
                    <th class="th-titulo">Email</th>
                    <th class="th-titulo">Telefono</th>
                    <th class="th-titulo">Fecha respuesta enviada</th>
                    <th class="th-titulo">Empleado</th>
                    <th class="th-titulo">Estado</th>
                    <th class="th-titulo">Información</th>
                    <th class="th-titulo">Imprimir Comprobante</th>
                    <th class="th-titulo">Tipo</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>

</section>

<script>
    function confirmarAsistencia(solicitudTurno_id, solicitudTurno_legajo, solicitudTurno_codigo) {
        $('.help-block').remove(); // Limpieza de los mensajes de alerta.
        $("#confirmarAsistencia").modal();
        var id = $("#confirma_id");
        var codigo = $("#confirma_codigo");
        var legajo = $("#confirma_legajo");
        id.val("");
        codigo.val("");
        legajo.val("");
        //==========
        if (solicitudTurno_codigo == "" || solicitudTurno_codigo == null) {
            $("#posible_ocultar").attr('class', 'ocultar');
            // $('#mensaje').append('<div class="help-block alert alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> El afiliado no tiene asignado ningún código. Por favor haga click en el botón "asignar nuevo código"</h4></div>');
            //FIXME: Ver si es necesario agregar un boton donde pueda generar y guardar el codigo nuevo al turnosolicitado.
        } else {
            $("#posible_ocultar").attr('class', 'mostrar');
            codigo.val(solicitudTurno_codigo);
        }
        id.val(solicitudTurno_id);
        legajo.val(solicitudTurno_legajo);

    }

    $(".alert-info").fadeTo(4000, 500).slideUp(500, function () {
        $(".alert-info").alert('close');
    });
    $(document).ready(function () {
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
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
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                }
            ],
            "columnDefs": [
                {
                    "targets": [10],
                    "visible": false,
                    "searchable": false
                }
            ],
            'pageLength': 10,
            'lengthMenu': [[10, 20, 50, 75, -1], [10, 20, 50, 75, 'Todos']]
            , "language": {
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
                if (aData[7] != "AUTORIZADO") {
                    $nRow.css({"color": "red"});
                }


            }
        });
        var myVar = setInterval(function () {
            myTimer()
        }, 220000);

        function myTimer() {
            tabla.ajax.reload();

        }
    })
    ;
    function guardarConfirmarAsistencia() {
        $('.help-block').remove(); // Limpieza de los mensajes de alerta.


        var datos = {
            'solicitudTurno_id': document.getElementById('confirma_id').value,
            'solicitudTurno_legajo': document.getElementById('confirma_legajo').value
        };
        //==========
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/impsweb/turnos/confirmarRespuestaAjax', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                .done(function (data) {
                    //console.log(data);
                    if (!data.success) {
                        $('#mensaje').append('<div class="help-block  alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '</h4></div>'); // add the actual error message under our input
                    } else {
                        $('#mensaje').append('<div class="help-block  alert-success"><h4>' + data.mensaje + '</h4></div>');
                        setTimeout(function () {
                            $("#confirmarAsistencia").hide(500);
                        }, 1000);

                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
    }
</script>
<!-- Modal -->
<div class="modal fade" id="confirmarAsistencia" role="dialog">
    <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xs-12" style="margin-top: 6%" align="center">
        <div class="modal-dialog ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">

                    <h1><i class="fa fa-question-circle fa-3x bg-info-icon" aria-hidden="true"></i></h1>

                    <h3>Por favor presione el botón CONFIRMAR si el afiliado informó que fue notificado.</h3>

                    <div id="mensaje"></div>
                    <hr>
                    {{ hidden_field('confirma_id') }}
                    <p><strong>LEGAJO</strong> {{ text_field('confirma_legajo','readOnly':'true') }}</p>

                    <p id="posible_ocultar">
                        <strong>CODIGO</strong> {{ text_field('confirma_codigo','readOnly':'true') }}</p>
                    <hr>
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-success" onclick="guardarConfirmarAsistencia()">CONFIRMAR</button>

                </div>
            </div>

        </div>
    </div>
</div>