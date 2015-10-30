<!-- Slider-->

<!-- BEGIN SLIDER AREA-->
<div class="slider_area">
    <!-- BEGIN SLIDER-->
    <div id="slides">
        <ul class="slides-container">

            <!-- THE FIRST SLIDE-->
            <li>
                <a href="#about" class="slow" style="text-decoration: none;">
                    <!-- FIRST SLIDE OVERLAY -->
                    <div class="slider_overlay"></div>
                    <!-- FIRST SLIDE MAIN IMAGE -->
                    {{ image('img/full-slider/full-slide1.jpg','alt':'slider imps') }}
                    <!-- FIRST SLIDE CAPTION-->
                    <div class="slider_caption">
                        <h2 class="borde-bottom">IMPS</h2>
                        <p>Instituto Municipal de Previsión Social</p>
                        <a href="#about" class="slider_btn slow">Iniciar Recorrido</a>
                    </div>
                </a>
            </li>

            <!-- THE SECOND SLIDE-->
            <li>
                <a href="#service" class="slow" style="text-decoration: none;">
                    <!-- SECOND SLIDE OVERLAY -->
                    <div class="slider_overlay"></div>
                    <!-- SECOND SLIDE MAIN IMAGE -->
                    {{ image('img/full-slider/full-slide2.jpg','alt':'servicios') }}
                    <!-- SECOND SLIDE CAPTION-->
                    <div class="slider_caption">
                        <h2 class="borde-bottom">Solicitud de Turnos Online</h2>
                        <p>Para solicitar o consultar sobre los prestamos puedes sacar tu turno a través de la web.</p>
                        <a href="#service" class="slider_btn slow">Ver Servicios</a>
                    </div>
                </a>
            </li>

            <!-- THE THIRD SLIDE-->
            <li>
                <a href="#works" class="slow" style="text-decoration: none;">
                    <!-- THIRD SLIDE OVERLAY -->
                    <div class="slider_overlay"></div>
                    <!-- THIRD SLIDE MAIN IMAGE -->
                    {{ image('img/full-slider/full-slide7.jpg','alt':'tramites') }}
                    <!-- THIRD SLIDE CAPTION-->
                    <div class="slider_caption">
                        <h2 class="borde-bottom">Necesitas ayuda para realizar los Trámites?</h2>
                        <p>Te ofrecemos una guía detallada para que puedas realizar tus trámites sin problemas</p>
                        <a href="#works" class="slider_btn slow">Ver Guía de Tramites</a>
                    </div>
                </a>
            </li>
        </ul>
        <!-- BEGAIN SLIDER NAVIGATION -->
        <nav class="slides-navigation">
            <!-- PREV IN THE SLIDE -->
            <a class="prev" href="/item1">
                <span class="icon-wrap"></span>
                <h3><strong>Anterior</strong></h3>
            </a>
            <!-- NEXT IN THE SLIDE -->
            <a class="next" href="/item3">
                <span class="icon-wrap"></span>
                <h3><strong>Siguiente</strong></h3>
            </a>
        </nav>
    </div>
    <!-- END SLIDER-->
</div>
<!-- END SLIDER AREA -->