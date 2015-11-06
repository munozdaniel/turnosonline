<!--=========== BEGIN HEADER SECTION ================-->
<header id="header">
    <!-- BEGIN MENU -->
    <div class="menu_area">
        <nav class="navbar navbar-default navbar-fixed-top">
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
                        {{ image('img/logoS.png','id':'logo','alt':'logo imps','style':'top: 0%;left: 2%;display: inline-block !important; margin: -10% 0% 0% 0%;width: 30%;') }}
                        I.M.<span>P.S.</span>
                    </a>
                    <!-- IMG BASED LOGO  -->
                    <!--  <a class="navbar-brand" href="#"><img src="img/logo.png" alt="logo"></a> -->
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="top-menu-admin" class="nav navbar-nav navbar-right main_nav">
                        <li class="active ">{{ link_to('index/index#','class':'si_recorrer','Inicio' )}}</li>
                        <li>{{ link_to('index/index#about','class':'si_recorrer','Informacion') }}</li>
                        <li>{{ link_to('index/index#service','class':'si_recorrer','Servicios') }}</li>
                        <li>{{ link_to('index/index#works','class':'si_recorrer','Guía de Tramites') }}</li>
                        <li>{{ link_to('index/index#team','class':'si_recorrer','Prestaciones' )}}</li>
                        <li id="opciones-institucion" class="dropdown">
                            <button class="btn btn-menu dropdown-toggle" type="button" id="desplegar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Institución
                                <span class="caret"></span>
                            </button>
                            <ul id="miSubMenu" class="dropdown-menu main_nav" aria-labelledby="desplegar" style="color: #FFF !important;;">
                                <li>{{ link_to('index/index#contact','class':'si_recorrer','CONTACTANOS') }}</li>
                                <li>{{ link_to('index/index#contact','class':'si_recorrer','INFORMACIÓN DE CONTACTO') }}</li>
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