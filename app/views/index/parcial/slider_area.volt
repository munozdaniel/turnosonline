<!-- Slider-->

<!-- BEGIN SLIDER AREA-->
<div class="slider_area">
    <!-- BEGIN SLIDER-->
    <div id="slides">
        <ul class="slides-container">

            <!-- THE FIRST SLIDE-->
            <li>
                <!-- FIRST SLIDE OVERLAY -->
                <div class="slider_overlay"></div>
                <!-- FIRST SLIDE MAIN IMAGE -->
                {{ image('img/full-slider/full-slide1.jpg','alt':'slider imps') }}
                <!-- FIRST SLIDE CAPTION-->
                <div class="slider_caption">
                    <h2>IMPS</h2>
                    <p>Instituto Municipal de Previsión Social</p>
                    <a href="#about" class="slider_btn">Iniciar Recorrido</a>
                </div>
            </li>

            <!-- THE SECOND SLIDE-->
            <li>
                <!-- SECOND SLIDE OVERLAY -->
                <div class="slider_overlay"></div>
                <!-- SECOND SLIDE MAIN IMAGE -->
                {{ image('img/full-slider/full-slide2.jpg','alt':'servicios') }}
                <!-- SECOND SLIDE CAPTION-->
                <div class="slider_caption">
                    <h2>Solicitud de Turnos Online</h2>
                    <p>Para solicitar o consultar sobre los prestamos puedes sacar tu turno a traves de la web.</p>
                    <a href="#service" class="slider_btn">Ver Servicios</a>
                </div>
            </li>

            <!-- THE THIRD SLIDE-->
            <li>
                <!-- THIRD SLIDE OVERLAY -->
                <div class="slider_overlay"></div>
                <!-- THIRD SLIDE MAIN IMAGE -->
                {{ image('img/full-slider/full-slide7.jpg','alt':'tramites') }}
                <!-- THIRD SLIDE CAPTION-->
                <div class="slider_caption">
                    <h2>Necesitas ayuda para realizar los Trámites?</h2>
                    <p>Te ofrecemos una guía detallada para que puedas realizar tus trámites sin problemas</p>
                    <a href="#works" class="slider_btn">Ver Guía de Tramites</a>
                </div>
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