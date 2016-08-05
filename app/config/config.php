<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => '192.168.42.14',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'impsorg_web',
        'charset'     => 'utf8',
    ),
    'gestionusuarios' => array(
        'adapter'     => 'Mysql',
        'host'        => '201.251.125.209:4880',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'gestionusuarios',
        'charset'     => 'utf8',
    ),
    'sujypweb' => array(
        'adapter'     => 'Mysql',
        'host'        => '201.251.125.209:4880',
        'username'    => 'root',
        'password'    => 'infoimps',
        'dbname'      => 'sujypweb',
        'charset'     => 'utf8',
    ),
    'siprea' => array(
        'adapter'     => 'Mysql',
        'host'        => '192.168.42.74',
        'username'    => 'root',
        'password'    => 'centosya',
        'dbname'      => 'siprea2',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'formsDir'       => APP_PATH . '/app/forms/',
        'curriculumDir'       => APP_PATH . '/app/forms/curriculum/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'mpdfDir'        => APP_PATH . '/app/library/mpdf/',
        'componentesDir'        => APP_PATH . '/app/library/componentes/',
        'phpmailerDir'   => APP_PATH . '/app/library/phpmailer/',
        'utilesDir'     => APP_PATH . '/app/library/utiles/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/turnosonline/',
    ),
    'mail' => array(
        'host'     => 'mail.imps.org.ar',
        'username'        => 'plantilla@imps.org.ar',
        'password'    => 'consul',
        'security'    => '',
        'port'      => '26',
        'charset'     => 'UTF-8',
        'email'     => 'consultas@imps.org.ar',
        'name'     => 'consul',
    ),
    'mailDesarrollo' => array(
        'host'     => 'mail.imps.org.ar',
        'username' => 'desarrollo@imps.org.ar',
        'password' => 'sis$%&--temas',
        'security' => '',
        'port'     => '26',
        'charset'  => 'UTF-8',
        'email'    => 'desarrollo@imps.org.ar',
        'name'     => 'IMPS - DIVISION AFILIADOS',
    )
));
