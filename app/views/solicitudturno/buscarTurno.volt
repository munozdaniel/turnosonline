<section id="onepage" class="admin bg_line">
    <div class="container ">
        <div align="center">
            <div class="curriculum-bg-header modal-header " align="left">
                <h1>
                    <ins>VER INFORMACIÓN DE TURNO</ins>
                    <br>
                </h1>
                <h3>
                    <small><em style=" color:#FFF !important;"> Ingrese los datos solicitados para buscar el turno.</em></small>
                </h3>
            </div>
            <hr>
            <div class="curriculum-bg-form borde-top" align="center">
                <div class="row">
                    <div class="col-md-12" align="center">

                        {{ content() }}

                        {{ form('solicitudTurno/verTurno','method':'post','style':'','class':'') }}

                            <div class="row">

                                <div class="col-md-4 col-md-offset-4">
                                    <label for="legajo" class="control-label">
                                        <strong style="color: red">*</strong> Legajo:</label>
                                    <input type="number" id="legajo" name="legajo"
                                           class="form-control user-error"
                                           style="text-align:right !important; font-size: 26px; height: 50px;width: 300px;" required="true" autocomplete="off"
                                           aria-invalid="true">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <label for="codigo" class="control-label">
                                        <strong style="color: red">*</strong> Código de Operación:</label>
                                    <a href="#" data-toggle="tooltip" class="text-decoration-none pull-right"
                                       title="El Código de Operación es el que se le envió por correo."><i class="fa fa-info-circle"></i></a>
                                    <input type="text" id="codigo" name="codigo"
                                           class="form-control user-error"
                                           style="text-align:right !important; font-size: 26px; height: 50px;width: 300px;" required="true" autocomplete="off" aria-invalid="true">
                                    <hr>
                                </div>
                             </div>

                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    {{ submit_button('BUSCAR','class':'btn btn-primary btn-lg') }}
                                </div>
                            </div>

                        {{ end_form() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>