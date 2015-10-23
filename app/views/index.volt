<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Needs
   ================================================== -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{ getTitle() }}

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="{{ url('img/favicon.ico') }}">
        <!-- CSS
        ================================================== -->
        <!-- Bootstrap css file-->
        {{ stylesheet_link('css/bootstrap.min.css') }}
        <!-- Font awesome css file-->
        {{ stylesheet_link('css/font-awesome.css') }}
        <!-- Superslide css file-->
        {{ stylesheet_link('css/superslides.css') }}
        <!-- Slick slider css file -->
        {{ stylesheet_link('css/slick.css') }}
        <!-- smooth animate css file -->
        {{ stylesheet_link('css/animate.css') }}
        <!-- Elastic grid css file -->
        {{ stylesheet_link('css/elastic_grid.css') }}
        <!-- Circle counter cdn css file -->
        <link rel='stylesheet prefetch' href='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/css/jquery.circliful.css'>
        <!-- Default Theme css file -->
        {{ stylesheet_link('css/themes/default-theme.css') }}
        <!-- Main structure css file -->
        {{ stylesheet_link('css/style.css') }}

        <!-- Google fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Varela' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
         {{ partial('parcial/preload') }}
        {{ content() }}
    </body>
    <!-- Javascript Files
       ================================================== -->

    <!-- initialize jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Google map -->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    {{ javascript_include('js/jquery.ui.map.js') }}
    <!-- For smooth animatin  -->
    {{ javascript_include('js/wow.min.js') }}
    <!-- Bootstrap js -->
    {{ javascript_include('js/bootstrap.min.js') }}
    <!-- superslides slider -->
    {{ javascript_include('js/jquery.superslides.min.js') }}
    <!-- slick slider -->
    {{ javascript_include('js/slick.min.js') }}
    <!-- for circle counter -->
    <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
    <!-- for portfolio filter gallery -->
    {{ javascript_include('js/modernizr.custom.js') }}
    {{ javascript_include('js/classie.js') }}
    {{ javascript_include('js/elastic_grid.min.js') }}
    {# javascript_include('js/portfolio_slider.js') #}
    <!-- Custom js-->
    {{ javascript_include('js/custom.js') }}
    {%  if (assets.collection("footer")) %}
        {{  assets.outputJs("footer") }}

    {% endif %}
    {%  if (assets.collection("footerInline")) %}
        {{  assets.outputInlineJs("footerInline") }}
    {% endif %}

</html>
