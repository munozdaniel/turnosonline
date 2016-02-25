<!--=========== BEGAIN TURNO EXITOSO SECTION ================-->
<section id="onepage" class="admin bg-rayado">
    <style>
        .heading h2 {font-size: 35px;line-height: 35px;}
    </style>
    <div class="container">
        <div class="row" align="center" style="margin-top: 30px;">
            <div class="heading">
                <h2 class="">Solicitud de Turno Exitoso</h2>
                {{ link_to('index/index','class':'btn btn-lg btn-primary pull-left','<i class="fa fa-home"></i> INICIO') }}
            </div>
        </div>
        <div class="row  form-blanco borde-top borde-left-4 borde-right-4 borde-bottom-4" style="margin-bottom: 250px;">
            <div class="" align="center">
                <h3 style="text-transform: uppercase">{{ content() }}</h3>

            <h1 style="color:#2f2f2f; text-transform: uppercase;">
                En breve se le enviará un mensaje a su correo electrónico para confirmar el turno.
                <br>
                <br>
                <em style="text-emphasis-color: steelblue; text-transform: none !important;">Recuerde revisar la carpeta spam (correo no deseado).</em>
            </h1>
                <br>
                <br>
                {{ link_to('index/index','class':'btn btn-lg btn-primary','<i class="fa fa-home"></i> VOLVER A LA PAGINA PRINCIPAL') }}

            </div>
        </div>


    </div>
</section>
<!--=========== END TURNO EXITOSO SECTION ================-->
