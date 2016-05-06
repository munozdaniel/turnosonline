<!--=========== BEGIN HEADER SECTION ================-->
<header id="header" class="menu_area">
    <!--MENU SECTION START-->
    <div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section" style="height: 50px;" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    {{ image('img/logoS.png','id':'logo','height':35,'width':55,'class':' visible-lg-inline visible-md-inline','alt':'logo imps','style':'display: inline-block; margin-top: -10px;') }}
                    <span class="hidden-sm" style="font-family: 'Archivo Black', sans-serif;font-weight: bolder; font-size:30px;">IMPS</span>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul id="top-menu" class="nav navbar-nav navbar-right main_nav">
                    <li class="active "><a href="#" class="si_recorrer">Inicio</a></li>
                    <li><a href="#about" class="si_recorrer">Información</a></li>
                    <li><a href="#service" class="si_recorrer">Servicios</a></li>
                    <li><a href="#works" class="si_recorrer">Guía de Tramites</a></li>
                    <li><a href="#team" class="si_recorrer">Prestaciones</a></li>
                    <li id="opciones-institucion" class="dropdown">
                        <button class="btn btn-menu dropdown-toggle" type="button" id="desplegar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Institución
                            <span class="caret"></span>
                        </button>
                        <ul id="miSubMenu" class="dropdown-menu main_nav" aria-labelledby="desplegar" style="color: #FFF !important;">
                            <li><a href="#contact" class="si_recorrer">Acerca de Nosotros</a></li>
                            <li role="separator" class="divider" style="width: 100%;"></li>
                            {{ elemento.getItemMenu() }}
                        </ul>
                    </li>
                    <li><a href="#clients" class="si_recorrer">Contactos</a></li>


                </ul>

            </div>

        </div>
    </div>
    <!--MENU SECTION END-->
    <!-- BEGIN MENU
    <div class="menu_area">
        <nav class="navbar navbar-default navbar-fixed-top past-main ">

            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        {{ image('img/logoS.png','id':'logo','class':' visible-lg-inline','alt':'logo imps','style':'top: 0%;left: 2%;display: inline-block ; margin: -5% 0% 0% 0%;width: 30%;') }}
                        <span style="font-family: 'Archivo Black', sans-serif;font-weight: bolder;">IMPS</span>
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="top-menu" class="nav navbar-nav navbar-right main_nav">
                        <li class="active "><a href="#" class="si_recorrer">Inicio</a></li>
                        <li><a href="#about" class="si_recorrer">Información</a></li>
                        <li><a href="#service" class="si_recorrer">Servicios</a></li>
                        <li><a href="#works" class="si_recorrer">Guía de Tramites</a></li>
                        <li><a href="#team" class="si_recorrer">Prestaciones</a></li>
                        <li id="opciones-institucion" class="dropdown">
                            <button class="btn btn-menu dropdown-toggle" type="button" id="desplegar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Institución
                                <span class="caret"></span>
                            </button>
                            <ul id="miSubMenu" class="dropdown-menu main_nav" aria-labelledby="desplegar" style="color: #FFF !important;">
                                <li><a href="#contact" class="si_recorrer">CONTACTANOS</a></li>
                                <li><a href="#clients" class="si_recorrer">INFORMACIÓN DE CONTACTO</a></li>
                                <li role="separator" class="divider" style="width: 100%;"></li>
                                {{ elemento.getItemMenu() }}
                            </ul>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>
    </div>
    <!-- END MENU -->
</header>
<!--=========== End HEADER SECTION ================-->
{{ content() }}