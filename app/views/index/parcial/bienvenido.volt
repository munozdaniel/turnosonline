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
    .container-bottom {
        position: absolute;
        bottom: 2em;
        right: 0;
    }
    /*Ribbons*/
   /* .wrapper {
        margin: 50px auto;
        width: 280px;
        height: 370px;
        background: white;
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
        -moz-box-shadow:    0px 0px 8px rgba(0,0,0,0.3);
        box-shadow:         0px 0px 8px rgba(0,0,0,0.3);
        position: relative;
        z-index: 90;
    }*/

    .ribbon-wrapper-green {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -3px;
        right: 15px;
    }

    .ribbon-green {
        font: bold 15px Sans-Serif;
        color: #333;
        text-align: center;
        text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
        -webkit-transform: rotate(45deg);
        -moz-transform:    rotate(45deg);
        -ms-transform:     rotate(45deg);
        -o-transform:      rotate(45deg);
        position: relative;
        padding: 7px 0;
        left: -5px;
        top: 15px;
        width: 120px;
        background-color: #BFDC7A;
        background-image: -webkit-gradient(linear, left top, left bottom, from(#BFDC7A), to(#8EBF45));
        background-image: -webkit-linear-gradient(top, #BFDC7A, #8EBF45);
        background-image:    -moz-linear-gradient(top, #BFDC7A, #8EBF45);
        background-image:     -ms-linear-gradient(top, #BFDC7A, #8EBF45);
        background-image:      -o-linear-gradient(top, #BFDC7A, #8EBF45);
        color: #6a6340;
        -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
        -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
        box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
    }

    .ribbon-green:before, .ribbon-green:after {
        content: "";
        border-top:   3px solid #6e8900;
        border-left:  3px solid transparent;
        border-right: 3px solid transparent;
        position:absolute;
        bottom: -3px;
    }

    .ribbon-green:before {
        left: 0;
    }
    .ribbon-green:after {
        right: 0;
    }
</style>

<div class="col-sm-12 col-xs-12 col-md-7 col-lg-8 novedades_slider">
    <h3 class=""  align="center"><strong>NOVEDADES</strong> </h3>

    <div class="nov slider responsive">
        <div class="col-xs-12 col-sm-12  col-md-3 col-lg-4">
            <div class="thumbnail">
                {{ link_to('index/inauguracion','target':'_blank',
                image('img/novedades/inauguración345x250.jpg','alt':'Inauguracion') )}}
                <div class="caption">
                    <p>
                        {{ link_to('index/inauguracion','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>29/07/2016</small>
                    </p>
                    <strong>INAUGURACIÓN NUEVA SEDE</strong><br>
                    <small>Ahora sí, llegamos a nuestra nueva casa y te lo mostramos.</small>

                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-12  col-md-3 col-lg-4">

            <div class="thumbnail">
                <div class="wrapper">
                    <div class="ribbon-wrapper-green"><div class="ribbon-green">JULIO</div></div>
                    {{ link_to('index/catalogo','target':'_blank',
                    image('img/informacion/n_revista.jpg','alt':'Catalogo de revistas') )}}
                </div>

                <div class="caption">
                    <p>
                        {{ link_to('index/catalogo','target':'_blank','class':'btn btn-info btn-xs pull-right',
                        'ABRIR')}}
                        <i class="fa fa-calendar"></i> <small>01/07/2016</small>
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
