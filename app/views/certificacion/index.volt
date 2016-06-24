<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>CERTIFICACIÓN NEGATIVA</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> A través de este servicio, Ud. podrá obtener el
                            comprobante de Certificación Negativa que
                            acredita que
                            no registra antecedentes de Jubilación y/o Pensión del Instituto Municipal de Previsión
                            Social de la
                            Ciudad de Neuquén.</em></small>
                </h3>
            </div>
            {{ content() }}
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                        <div class="certificacion-info">
                            <hr>
                            <i class="fa fa-info-circle"
                               style="vertical-align: middle;font-size: 35px;color: #5e7b97;margin-left: 2%;margin-right: 1%;"></i>
                                    <span>
                                         <em>Por favor, ingrese el número de documento, <strong>SIN</strong> puntos ni
                                             comas, luego,
                                             presione sobre el botón <strong>Generar PDF</strong>.</em>
                                    </span>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="certificacion-form" align="center">
                            {{ form('certificacion/generar','method':'post') }}

                            <div class="col-md-8 col-md-offset-2 col-sm-12">
                                {{ content() }}
                            </div>
                            <div>
                                {{ certificacionForm.render('nroDoc') }}
                            </div>

                            <br>
                            <br>

                            <div class="col-md-4 col-md-offset-4">

                                {{ submit_button('GENERAR PDF','class':'btn btn-blue btn-lg btn-block') }}
                                <br>
                            </div>
                            {{ end_form() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>