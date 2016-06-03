<style>
    .body {
        font-family: Raleway;
        font-weight: 900;
        color: #fff;
    }

    .h1, .h2, .p, .strong {
        margin: 5px 0;
        padding: 0;
        margin-right: 130px;
        line-height: 1em;
        text-align: right;
        text-transform: uppercase;
        text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.3),
        1px 1px 1px rgba(0, 0, 0, .3),
        0 0 10px #000;
    }

    .h1 {
        font-size: 5.5em;
        letter-spacing: -10px;
        margin-bottom: -10px;
    }

    .h1 .strong {
        position: absolute;
        top: -50px;
        right: 0;
        font-size: 235px;
        opacity: .5;
        margin: 0;
    }

    .h2 {
        opacity: .6;
        font-size: 1.7em;
    }

    /*.p {
        font-size: 2em;
    }

    .tablas-news {
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 0 10px #000;
        text-shadow: 0 0 5px #000;
        color: #fff;

    }*/

    /* .a {
         position: absolute;
         left: 1em;
         bottom: 3em;
         border: 3px solid #fff;
         border-radius: 8px;
         box-shadow: 0 0 10px #000;
         padding: 20px 40px;
         text-align: center;
         text-decoration: none;
         text-shadow: 0 0 5px #000;
         font-size: 13px;
         color: #fff;
         animation: pulse 4s infinite;

     }*/

    .container-bottom {
        position: absolute;
        bottom: 2em;
        right: 0;
    }
</style>

<div class="col-sm-12 col-xs-12 col-md-7 col-lg-8 novedades_slider">
    <h3 class=""  align="center"><strong>NOVEDADES</strong> </h3>

    <div class="nov slider responsive">
        <div class="col-xs-12 col-sm-12  col-md-3 col-lg-4">

            <div class="thumbnail">
                {{ link_to('index/catalogo','target':'_blank',
                            image('img/informacion/n_revista.jpg','alt':'Catalogo de revistas') )}}
                <div class="caption">
                    <p>
                        {{ link_to('index/catalogo','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>01/05/2016</small>
                    </p>
                    <strong>REVISTA IMPS</strong><br>
                    <small>Todos los meses publicaremos una nueva edición.</small>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">

            <div class="thumbnail">
                {{ link_to('index/presentacionTurnos','target':'_blank',
                image('img/informacion/n_turnos.jpg','alt':'Guía para Solicitar Turno') )}}
                <div class="caption">
                    <p>
                        {{ link_to('index/presentacionTurnos','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>11/04/2016</small>
                    </p>
                    <strong>TURNOS ONLINE</strong><br>
                    <small>Proximámente habilitaremos un nuevo servicio.</small>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">

            <div class="thumbnail">
                {{ link_to('files/novedad/afiliados.pdf','target':'_blank',
                image('img/informacion/n_jub.jpg','alt':'Impuestos a la ganancia') )}}
                <div class="caption">
                    <p>
                        {{ link_to('files/novedad/afiliados.pdf','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>01/03/2016</small>
                    </p>
                    <strong>JUB. Y PENSIONADOS</strong><br>
                    <small>Información Impuestos a las Ganancias Periodo Fiscal 2015</small>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">

            <div class="thumbnail">
                {{ link_to('index/emprendimiento','target':'_blank',
                image('img/informacion/n-emprendimiento.jpg','alt':'Emprendimiento Marimenuco') )}}
                <div class="caption">
                    <p>
                        {{ link_to('index/emprendimiento','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>01/05/2014</small>
                    </p>
                    <strong>EMPRENDIMIENTO MARIMENUCO</strong><br><br>
                    <small>Instituto Municipal de Previsión Social</small>

                </div>
            </div>
        </div>
    </div>

</div>
<section id="inicio-slider" style="height: 600px">
    <div class=" body container-bottom pull-right">
        <h1 class="h1 strong">IMPS</h1>

        <h2 class="h2">Instituto Municipal </h2>

        <h2 class="h2">de Previsión Social</h2>
    </div>
</section>

<!--
<div class="tablas-news col-md-7" style="height: 275px; background-color: rgba(238, 238, 238, 0.8); margin-top: 14em;">

        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    {{ image('img/informacion/n_revista.jpg','alt':'Catalogo de revistas') }}
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    {{ image('img/informacion/n_revista.jpg','alt':'Catalogo de revistas') }}
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    {{ image('img/informacion/n_revista.jpg','alt':'Catalogo de revistas') }}
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                    </div>
                </div>
            </div>
        </div>

</div>
-->