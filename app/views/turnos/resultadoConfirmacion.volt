<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>TURNO PARA PRÉSTAMOS PERSONALES</ins>
                    <br>
                </h1>
                <h3><small><em style=" color:#FFF !important;"> Verificación de los datos</em></small></h3>
                <table class="" width="100%">
                    <tr>
                        <td align="right">{{ link_to("index", "<i class='fa fa-sign-out'></i> SALIR",'class':'btn btn-lg btn-primary') }}</td>
                    </tr>
                </table>

            </div>
            <hr>
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-md-12">
                        {% if solicitud_id is defined %}
                            {{ content() }}
                            {{ form('turnos/comprobanteTurnoPost','method':'POST') }}
                                    {{ hidden_field('solicitud_id',solicitud_id) }}
                            {{ end_form() }}
                        {% endif %}
                        <p>
                          Por cualquier consulta puede escribirnos <strong> consultas@imps.org.ar</strong>
                            o llamarnos al (0299) 4479921.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
