{# <meta http-equiv="refresh" content="35">#}

<style>
    .heading h2 {
        font-size: 35px;
        line-height: 35px;
    }
</style>

<script type="text/javascript">
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);
    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
    }


</script>

<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div class="row" align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>SOLICITAR TURNO MANUAL</ins>
                    <br>
                </h1>
                <ul>
                    <li><i class="fa fa-dot-circle-o"></i> Es muy importante que complete correctamente sus
                        datos personales, correo electrónico y teléfono.
                    </li>
                    <li><i class="fa fa-dot-circle-o"></i> Los campos que contienen * son obligatorios.</li>
                </ul>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("administrar/index", "<i class='fa fa-sign-out'></i> VOLVER",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>

            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
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
                                </h4>
                            </div>
                        </div>
                    {% endif %}
                    {{ form('turnos/guardarSolicitudManual','method':'post','style':'','class':'') }}
                    <div class="col-md-12" style="margin-bottom: 30px; text-align: left;">

                        <hr>
                        {% for elto in formulario %}
                            <div class="col-md-4">
                                {{ elto.label(['class': 'control-label']) }}
                                {{ elto }}
                                {{ formulario.messages(elto.getName()) }}
                            </div>
                            {% if loop.index == 3 OR loop.index == 6 %}
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            {% endif %}
                        {% endfor %}
                        <div class="col-md-4">
                            <label for="miselect">
                                <b style="color: red">* Estado de la solicitud:</b>
                            </label>
                            <select id="miselect" name="estado" required="true"
                                    class="form-control">
                                <option value="">SELECCIONAR UNA OPCIÓN</option>
                                <option value="AUTORIZADO">AUTORIZADO</option>
                                <option value="DENEGADO">DENEGADO</option>
                            </select>
                        </div>

                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3">
                        {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                    </div>
                </div>

                {{ end_form() }}
            </div>
        </div>
    </div>
</section>
<script>
    var myVar = setInterval(function () {
        myTimer()
    }, 1000);

    function myTimer() {
        $('#cantAutorizados').load(document.URL + ' #cantAutorizados');
    }

</script>