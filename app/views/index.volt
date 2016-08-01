<!DOCTYPE html>
<html class="bg_line">
<head>
    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    <meta name="description"
          content="El I.M.P.S. les ofrece a sus afiliados la posibilidad de informarse y de realizar sus
               operaciones online desde la comodidad de su hogar.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{ getTitle() }}
    <!-- Bootstrap js -->


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
    {{ stylesheet_link('css/font-awesome.min.css') }}
    <!-- smooth animate css file
    {{ stylesheet_link('css/animate.min.css') }}-->
    <!-- Default Theme css file -->
    {{ stylesheet_link('css/themes/default-theme.css') }}
    <!-- Main structure css file -->
    {% if (assets.collection("headerCss")) %}
        {{ assets.outputCss("headerCss") }}
    {% endif %}
    {% if (assets.collection("headerJs")) %}
        {{ assets.outputJs("headerJs") }}
    {% endif %}
    {% if (assets.collection("headerInline")) %}
        {{ assets.outputInlineJs("headerInline") }}
    {% endif %}

    {{ stylesheet_link('css/style.css') }}
    {# INAUGURACION: Eliminar cuando no se necesite#}

    {# FIN INAUGURACION#}
    <!-- Google fonts
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&amp;o3h5y6' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Varela' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    -->
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
{% if (assets.collection("jquery")) %}
    {{ assets.outputJs("jquery") }}
{% endif %}
{{ javascript_include('js/bootstrap.min.js') }}
{{ javascript_include('js/modernizr.custom.js') }}
{{ javascript_include('js/classie.min.js') }}
{{ javascript_include('js/custom.min.js') }}

{% if (assets.collection("footer")) %}
    {{ assets.outputJs("footer") }}
{% endif %}
{% if (assets.collection("footerInline")) %}
    {{ assets.outputInlineJs("footerInline") }}
{% endif %}

</html>
