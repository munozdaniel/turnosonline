<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Needs
   ================================================== -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php echo $this->tag->gettitle(); ?>

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>

        <!-- CSS
        ================================================== -->
        <!-- Bootstrap css file-->
        <?php echo $this->tag->stylesheetLink('css/bootstrap.min.css'); ?>
        <!-- Font awesome css file-->
        <?php echo $this->tag->stylesheetLink('css/font-awesome.css'); ?>
        <!-- Superslide css file-->
        <?php echo $this->tag->stylesheetLink('css/superslides.css'); ?>
        <!-- Slick slider css file -->
        <?php echo $this->tag->stylesheetLink('css/slick.css'); ?>
        <!-- smooth animate css file -->
        <?php echo $this->tag->stylesheetLink('css/animate.css'); ?>
        <!-- Elastic grid css file -->
        <?php echo $this->tag->stylesheetLink('css/elastic_grid.css'); ?>
        <!-- Circle counter cdn css file -->
        <link rel='stylesheet prefetch' href='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/css/jquery.circliful.css'>
        <!-- Default Theme css file -->
        <?php echo $this->tag->stylesheetLink('css/themes/default-theme.css'); ?>
        <!-- Main structure css file -->
        <?php echo $this->tag->stylesheetLink('css/style.css'); ?>

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
         <?php echo $this->partial('parcial/preload'); ?>
        <?php echo $this->getContent(); ?>
    </body>
    <!-- Javascript Files
       ================================================== -->

    <!-- initialize jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Google map -->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <?php echo $this->tag->javascriptInclude('js/jquery.ui.map.js'); ?>
    <!-- For smooth animatin  -->
    <?php echo $this->tag->javascriptInclude('js/wow.min.js'); ?>
    <!-- Bootstrap js -->
    <?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
    <!-- superslides slider -->
    <?php echo $this->tag->javascriptInclude('js/jquery.superslides.min.js'); ?>
    <!-- slick slider -->
    <?php echo $this->tag->javascriptInclude('js/slick.min.js'); ?>
    <!-- for circle counter -->
    <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
    <!-- for portfolio filter gallery -->
    <?php echo $this->tag->javascriptInclude('js/modernizr.custom.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/classie.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/elastic_grid.min.js'); ?>
    
    <!-- Custom js-->
    <?php echo $this->tag->javascriptInclude('js/custom.js'); ?>
    <?php if (($this->assets->collection('footer'))) { ?>
        <?php echo $this->assets->outputJs('footer'); ?>

    <?php } ?>
    <?php if (($this->assets->collection('footerInline'))) { ?>
        <?php echo $this->assets->outputInlineJs('footerInline'); ?>
    <?php } ?>

</html>
