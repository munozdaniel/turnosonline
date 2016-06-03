<section id="onepage" class="admin bg-rayado">

    <style>
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>

    <div class="container">

        <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4" style="margin-bottom: 250px;">
            <div class="" align="center">
                <h3 style="text-transform: uppercase">
                    <strong>{{ content() }}</strong>
                </h3>

                <br/>

                <div class=" col-xs-12 col-sm-12 col-md-5 col-md-offset-4">
                    {{ link_to('turnos/turnosRespondidos','class':'btn btn-blue btn-lg btn-block','<i class="fa fa-send"></i> VER LISTADO DE TURNOS RESPONDIDOS') }}
                </div>

                <br/><br/>

            </div>
        </div>

    </div>

</section>