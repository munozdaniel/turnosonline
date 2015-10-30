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
                        <li class="active">{{ link_to('index/index','INICIO') }}</li>
                        <li>{{ link_to('administrar/index','PANEL DE CONTROL') }}</li>
                        {{ elemento.getItemMenu() }}
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
    </div>
    <!-- END MENU -->
</header>
<!--=========== End HEADER SECTION ================-->
{{ content() }}