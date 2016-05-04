<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>TURNO SOLICITADO</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> A continuación puede imprimir el comprobante o cancelar
                            el turno.</em></small>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="legajo" class="control-label">
                                <strong style="color: red">*</strong> Legajo:</label>
                            <input type="number" id="legajo" name="legajo"
                                   class="form-control user-error"
                                   style="text-align:right !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL LEGAJO" required="true" autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ legajo }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="control-label">
                                <strong style="color: red">*</strong> Apellido y Nombre:</label>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control user-error"
                                   style="text-align:right !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL APELLIDO Y EL NOMBRE" required="true"
                                   autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ apeNombre }}">
                        </div>
                        <div class="col-md-4">
                            <label for="codigo" class="control-label">
                                <strong style="color: red">*</strong> Código de Operación:</label>
                            <input type="text" id="codigo" name="codigo"
                                   class="form-control user-error"
                                   style="text-align:right !important; font-size: 18px; height: 40px"
                                   placeholder="NO SE ENCONTRÓ EL CODIGO" required="true" autocomplete="off"
                                   aria-invalid="true" readonly="true" value="{{ codigo }}">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            {{ form('turnos/comprobanteTurnoPost','method':'POST') }}
                            {{ hidden_field('solicitud_id',solicitud_id) }}
                            <button type='submit' class='btn btn-info btn-lg' formtarget='_blank'><i
                                        class='fa fa-print'></i> IMPRIMIR COMPROBANTE DE TURNO
                            </button>
                            {{ end_form() }}
                        </div>
                        <div class="col-md-4 ">
                            <a data-toggle="modal"
                               data-target="#confirmarCancelacion" class='btn btn-danger btn-lg'><i
                                        class='fa fa-print'></i> CANCELAR TURNO ONLINE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmarCancelacion" class="modal fade " style="background-color: #006688;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmar Cancelación del Turno</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Está seguro de cancelar el turno? </h3>
                                {{ form('turnos/cancelarTurno','id':'cancelarForm','method':'POST') }}
                                <div id="mensaje_modal"></div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        {{ text_field('codigoSeguridad','value':codigoSeguridad ,'readOnly':'true',
                                        'style':'font-weight: bold;color:#FFF !important; background-color: red !important;text-align:right !important; font-size: 18px; height: 40px','class':'form-control') }}
                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" style="height: 40px"
                                            onclick="actualizarCodigo()"><i
                                                class="fa fa-refresh "></i></button>
                                </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    {{ text_field('codigoRepetido','required':'true','class':'form-control','placeholder':'INGRESE EL CÓDIGO DE SEGURIDAD','style':'text-align:right !important; font-size: 18px; height: 40px') }}
                                </div>
                                <div class="col-md-4 ">
                                    {{ submit_button('Cancelar turno','class':'btn btn-lg btn-danger') }}
                                </div>
                                {{ end_form() }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-green btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function actualizarCodigo() {
        chars = "0123456789ABCDEFGHIJKM";
        lon = 5;

        code = "";
        for (x = 0; x < lon; x++) {
            rand = Math.floor(Math.random() * chars.length);
            code += chars.substr(rand, 1);
        }
        document.getElementById('codigoSeguridad').value = code;
    }
    $('#cancelarForm').submit(function (event) {
        $("#mensaje_modal").empty();
        datos = {
            'codigoSeguridad': $('#codigoSeguridad').val(),
            'legajo': $('#legajo').val(),
            'codigo': $('#codigo').val(),
            'codigoRepetido': $('#codigoRepetido').val()
        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/impsweb/turnos/cancelarTurnoAjax', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                .done(function (data) {
                  //  console.log(data);
                    if(data.success)
                    {
                        $('#mensaje_modal').append('<div class="alert  alert-info">' +
                        '<h4>  ' + data.mensaje + '<br> Redireccionando...</h4></div>');
                        setTimeout("redireccionar()", 3000); //tiempo expresado en milisegundos

                    }else{
                        $('#mensaje_modal').append('<div class="alert  alert-danger">' +
                        '<h4>  ' + data.mensaje + '</h4></div>');
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        event.preventDefault();

    });//Fin: ready
    function redireccionar() {
        window.location = "/libro/nota/search" ;
    }
</script>