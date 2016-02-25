<section id="onepage" class="admin bg-rayado">

    <div class="container">
            <div class="row" align="center" style="margin-top: 30px;">
                <div class="heading">

                    {{ link_to('index/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-home"></i> INICIO') }}
                </div>
            </div>
        <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4" style="margin-bottom: 250px;">
            <div class="" align="center">
                <h3 style="text-transform: uppercase">{{ content() }}</h3>
                <br>
                <br>
                {{ link_to('index/index','class':'btn btn-lg btn-primary','<i class="fa fa-home"></i> VOLVER A LA PAGINA PRINCIPAL') }}

            </div>
        </div>
    </div>
</section>