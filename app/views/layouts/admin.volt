<!--=========== BEGIN HEADER SECTION ================-->
<header id="header">
    <!-- BEGIN MENU -->
    <div class="menu_area">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- LOGO -->
                    <!-- TEXT BASED LOGO -->
                    <a class="navbar-brand" href="#">
                        {{ image('img/logo.png','id':'logo','alt':'logo imps','style':'top: 0%;left: 2%;display: inline-block !important; margin: -10% 0% 0% 0%;width: 30%;') }}
                        IM<span>PS</span>
                    </a>
                    <!-- IMG BASED LOGO  -->
                    <!--  <a class="navbar-brand" href="#"><img src="img/logo.png" alt="logo"></a> -->
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="top-menu-admin" class="nav navbar-nav navbar-right main_nav">
                        <li class="active "><a href="index#" class="si_recorrer">Inicio</a></li>
                        <li><a href="index#about" class="si_recorrer">Información</a></li>
                        <li><a href="index#service" class="si_recorrer">Servicios</a></li>
                        <li><a href="index#works" class="si_recorrer">Guía de Tramites</a></li>
                        <li><a href="index#team" class="si_recorrer">Prestaciones</a></li>
                        <li class="dropdown" style="cursor: pointer; cursor: hand;">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                Institución <span class="caret"></span>
                            </a>
                            <ul id="miSubMenu" class="dropdown-menu nav navbar-nav navbar-right main_nav">
                                <li><a href="index#contact" class="si_recorrer">Contactanos</a></li>
                                <li><a href="index#clients" class="si_recorrer">Información de Contacto</a></li>
                                <li role="separator" class="divider" style="width: 100%;"></li>
                                {{ elemento.getItemMenu() }}
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
    </div>
    <!-- END MENU -->
</header>
<!--=========== End HEADER SECTION ================-->
{{ content() }}