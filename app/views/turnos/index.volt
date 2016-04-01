<section id="onepage" class="admin curriculum-bg">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>SOLICITAR TURNO PARA PRÉSTAMOS PERSONALES</ins>
                    <br>
                </h1>
                <h3><small><em style=" color:#FFF !important;"> Complete sus datos para solicitar un turno</em></small></h3>
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
                        {{ form('turnos/guardarTurnoOnline','method':'post','style':'','class':'') }}
                        <div class="col-md-12" style="margin-bottom: 30px; text-align: left;">
                            <ul>
                                <li><i class="fa fa-dot-circle-o"></i> Es muy importante que complete correctamente sus datos personales, correo electrónico y  teléfono.</li>
                                <li><i class="fa fa-dot-circle-o"></i> Los campos que contienen * son obligatorios.</li>
                                <li><i class="fa fa-dot-circle-o"></i> Al finalizar, nuestros empleados analizarán su estado de deuda y le enviarán un correo electrónico.</li>
                            </ul>
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

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                {% if deshabilitar is defined %}
                                    {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block disabled') }}
                                {% else %}
                                    {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block') }}
                                {% endif %}
                            </div>
                        </div>

                        {{ end_form() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
