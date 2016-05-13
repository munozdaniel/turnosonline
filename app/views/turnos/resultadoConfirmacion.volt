<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>TURNO PARA PRÉSTAMOS PERSONALES</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> Verificación de los datos</em></small>
                </h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            <div class="curriculum-bg-form borde-top">
                <div class="row">
                    <div class="col-md-12">
                        {{ content() }}
                        {% if solicitud is defined %}
                            {% if mensaje_alerta is defined %}

                                <div class="alert alert-info" align="left">
                                    <h1>
                                        <i class="fa fa-info-circle " style="display: inline-block"></i>
                                        {{ mensaje_alerta }}
                                    </h1>
                                </div>
                            {% endif %}

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
                            <div class="col-md-8 col-md-offset-2">
                                <div class="table-responsive">
                                    <table class="table" style=" font-size: 24px; border: 2px solid darkgray;">
                                        <tr>
                                            <td class="layout" align="left" style="font-weight: bold; ">
                                                <ins>COMPROBANTE DE TURNO</ins>
                                            </td>
                                            <td align="right" style="font-weight: bold; ">
                                                {% if mensaje_boton is defined %}
                                                    {{ mensaje_boton }}
                                                {% endif %}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="layout" align="left" style="font-weight: bold; ">Código
                                                de Turno
                                            </td>
                                            <td align="right" style="font-weight: bold; ">
                                                {{ solicitud.getSolicitudturnoCodigo() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="layout" align="left"
                                                style="font-weight: bold; border-bottom: 2px dotted #607D8B">
                                                Período de Atención
                                            </td>
                                            <td align="right"
                                                style="font-weight: bold; border-bottom: 2px dotted #607D8B">
                                                {{ date('d/m/Y',(periodo.getFechasturnosDiaatencion()) | strtotime) }}
                                                al {{ date('d/m/Y',(periodo.getFechasturnosDiaatencionfinal()) | strtotime) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="layout" align="left">Apellido/s y Nombre/s</td>
                                            <td align="right">{{ solicitud.getSolicitudturnoNomape() }}</td>
                                        </tr>


                                        <tr>
                                            <td class="layout" align="left">Nº de Documento</td>
                                            <td align="right">{{ solicitud.getSolicitudturnoDocumento() }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="layout" align="left">Legajo</td>
                                            <td align="right"> {{ solicitud.getSolicitudturnoLegajo() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="layout" align="left">Turno confirmado el día:</td>
                                            <td align="right">
                                                {{ date('d/m/Y',(solicitud.getSolicitudturnoFechaconfirmacion()) | strtotime) }}
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        {% endif %}
                        {% if solicitud_id is defined %}
                            {{ form('turnos/comprobanteTurnoPost','method':'POST') }}
                            {{ hidden_field('solicitud_id',solicitud_id) }}
                            {{ end_form() }}
                        {% endif %}
                        <div class="col-md-12">
                        <p>
                            Por cualquier consulta puede escribirnos <strong> consultas@imps.org.ar</strong>
                            o llamarnos al (0299) 4479921.
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
