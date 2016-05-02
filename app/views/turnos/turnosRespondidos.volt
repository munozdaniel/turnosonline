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
                <div class=" col-sm-2 col-sm-offset-2">
                    <div class="cuadrado-rojo"><i class="fa fa-bookmark"></i></div>
                    <strong> TODOS</strong>

                </div>
                <div class=" col-sm-2">

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
            <table id="tabla" class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th class="th-titulo">Codigo</th>
                    <th class="th-titulo">Legajo</th>
                    <th class="th-titulo">Apellido y nombre</th>
                    <th class="th-titulo">Email</th>
                    <th class="th-titulo">Telefono</th>
                    <th class="th-titulo">Estado</th>
                    <th class="th-titulo">Fecha respuesta enviada</th>
                    <th class="th-titulo">Empleado</th>
                    <th class="th-titulo">Confirma Asistencia</th>
                    <th class="th-titulo">Imprimir Comprobante</th>
                    <th class="th-titulo">Tipo</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</section>
<script>
    $(".alert-info").fadeTo(4000, 500).slideUp(500, function () {
        $(".alert-info").alert('close');
    });
    $(document).ready(function () {
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
                    action: function ( e, dt, node, config ) {
                        table.ajax.reload();
                    }
                },
                {
                    text:"Exportar PDF",
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exportar EXCEL'
                }
            ],
            "columnDefs": [
                {
                    "targets": [ 10 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            'pageLength': 10,
            'lengthMenu': [[10, 20, 50, 75, -1], [10, 20, 50, 75, 'Todos']]
            ,"language": {
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
                if (aData[5] != "AUTORIZADO") {
                    $nRow.css({"color": "red"});
                }
                if (aData[10] == 1) {
                    $nRow.css({"background-color": "rgba(126, 191, 227, 0.1)"});
                } else {
                    if (aData[10] == 2) {
                        $nRow.css({"background-color": "rgba(19, 143, 44, 0.1)"});
                    } else {
                        if (aData[10] == 3) {
                            $nRow.css({"background-color": " rgba(255, 211, 95, 0.1)"});
                        }
                    }
                }

            }
        });
        var myVar = setInterval(function () {
            myTimer()
        }, 20000);

        function myTimer() {
            tabla.ajax.reload();

        }
    })
    ;
</script>