<section id="onepage" class="admin bg_line">
    <div class="container">

        {{ content() }}

        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">

                <h1>
                    <ins>LISTA DE TURNOS SOLICITADOS</ins>
                    {{ link_to("turnos/verPeriodos", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary','style':'margin-left:35%;background-color:#195889;') }}
                    <br>
                </h1>

            </div>
        </div>
        <br/>

        <div class="row form-blanco borde-top borde-left-4 borde-right-4">

            <div class="col-sm-6" align="center">
                <h3><strong>
                        <ins>PERIODO DE SOLICITUD</ins>
                    </strong>
                </h3>

                <h4>
                    Desde {{ ffInicioSol }} <br/> Hasta {{ ffFinSol }}
                </h4>

            </div>

            <div class="col-sm-6" align="center">
                <h3>
                    <strong>
                        <ins>PERIODO DE ATENCI&Oacute;N</ins>
                    </strong>
                </h3>

                <h4>
                    Desde {{ffInicioAtencion}} <br/> Hasta {{ ffFinAtencion }}
                </h4>
            </div>

        </div>


        <div class="row form-blanco borde-top borde-left-4 borde-right-4">

            <br/>

            <div id="solicitudes" class="col-lg-12 col-md-12 table-responsive">
                <table id="tabla" class="table_r table-striped table-bordered table-condensed">
                    <thead style="background-color: #131313;">
                    <tr>
                        <th class="th-titulo">ID</th>{# 0 #}
                        <th class="th-titulo">Estado Asistencia ID</th>{# 1: Online o Terminal #}
                        <th class="th-titulo">C&oacute;digo</th>{# 2 #}
                        <th class="th-titulo">Afiliado</th>{# 3: Legajo y Nombre #}
                        <th class="th-titulo">Email/Telefono</th>{# 4 #}
                        <th class="th-titulo">Usuario</th>{# 5 #}
                        <th class="th-titulo">Estado</th>{# 6 Estado de Deuda: Autorizado - Denegado - Denegado por Falta de Turno#}
                        <th class="th-titulo">Observaci&oacute;n</th>{# 7 #}
                        <th class="th-titulo">Estado de asistencia</th>{# 8 En espera - Confirmado - Plazo vencido - cancelado#}
                        <th class="th-titulo">Tipo Solicitud</th>{# 9 #}
                    </tr>
                    </thead>
                </table>
            </div>

        </div>

    </div>
</section>

<script>
    $(document).ready(function ()
    {
        var ffIS = '{{ ffInicioSol }}';
        var ffFS = '{{ ffFinSol }}';
        var ffIA = '{{ ffInicioAtencion }}';
        var ffFA = '{{ ffFinAtencion }}';
        var id  = {{ idP }};

        var tabla = $('#tabla').DataTable
        ({
            ajax:
            {
                 url: '/impsweb/turnos/solicitudesPorPeriodoAjax/?id='+id,
                 type: 'POST',
                 dataType: 'json',
            },
            "processing": true,
            dom: 'Bfrtlip',
            buttons:
            [
                {
                    text: "Exportar PDF",
                    title: "Listado de turnos",
                    message:"Periodo de solicitud: "+ffIS+' - '+ffFS+'   Periodo de atencion: '+ffIA+' -'+ffFA,
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open',
                    exportOptions: {
                        columns:[2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }
            ],
            "columnDefs":
            [
                {
                    "targets": [0,1],
                    "visible": false,
                    "searchable": false
                }
            ],
            'pageLength': 10,
            'lengthMenu': [[10, 20, 40, -1], [10, 20, 40, 'Todos']],
            "language":
            {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "B&uacute;squeda General:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "&Uacute;ltimo",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },

        });
    });
</script>