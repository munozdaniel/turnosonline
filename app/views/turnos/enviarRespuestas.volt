<section id="onepage" class="admin bg-rayado">
    <style>
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>
    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                {{ link_to('turnos/turnosSolicitados','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-arrow-left"></i> VOLVER') }}
            </div>
        </div>
        <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4" style="margin-bottom: 250px;">
            <div class="" align="center">
                <h3 style="text-transform: uppercase">
                    <strong>{{ content() }}</strong>
                </h3>
                <hr>
                <h4 style='font-family: "Oswald", sans-serif'>
                    <em>Por favor, revisar el listado de turnos respondidos para ver aquellos afiliados que vinieron personalmente <br>
                        a solicitar el turno, es necesario informarles de su estado.
                    </em>
                    <br>
                </h4>
                <hr>
                {{ link_to('turnos/turnosRespondidos','class':'btn btn-lg btn-primary','<i class="fa fa-send"></i> VER LISTADO DE SOLICITUDES OTORGADAS') }}

                <br>
                <br>

            </div>
        </div>


    </div>
</section>