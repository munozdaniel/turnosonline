<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>SOLICITAR TURNO PARA PRÉSTAMOS PERSONALES</ins>
                    <br>
                </h1>
                <h3><small><em style=" color:#FFF !important;">Complete con sus datos personales el siguiente formulario.

                        </em></small></h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-home'></i> VOLVER",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-md-12">
                        {{ form('solicitudTurno/guardarTurnoOnline','method':'post','style':'','class':'') }}
                        <div class="col-md-12" style="margin-bottom: 30px; text-align: left;">
                            <ul><strong><ins>INSTRUCCIONES</ins></strong>
                                <li><i class="fa fa-dot-circle-o"></i> Es muy importante que complete correctamente sus datos personales, correo electrónico y teléfono.</li>
                                <li><i class="fa fa-dot-circle-o"></i> Los campos que contienen * son obligatorios.</li>
                                <li><i class="fa fa-dot-circle-o"></i> Al finalizar, nuestros empleados analizarán su petici&oacute;n y le enviarán un correo electrónico.</li>
                                <li><i class="fa fa-dot-circle-o"></i> Recuerde que solo los <strong>afiliados activos</strong> pueden solicitar un turno online.</li>
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
                                {% if deshabilitar is defined AND deshabilitar == true %}
                                    {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block disabled','style':'width:360px;') }}
                                {% else %}
                                    {{ submit_button('GUARDAR DATOS','class':'btn btn-blue btn-lg btn-block','style':'width:360px;') }}
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
