<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'impsorg_web',
        'charset'     => 'utf8',
    ),
    'gestionusuarios' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'gestionusuarios',
        'charset'     => 'utf8',
    ),
    'sujypweb' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'sujypweb',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'formsDir'       => APP_PATH . '/app/forms/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'mpdfDir'        => APP_PATH . '/app/library/mpdf/',
        'phpmailerDir'   => APP_PATH . '/app/library/phpmailer/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/impsweb/',
    ),
    'mail' => array(
        'host'     => 'mail.imps.org.ar',
        'username'        => 'plantilla@imps.org.ar',
        'password'    => 'dan$%&--iel',
        'security'    => '',
        'port'      => '26',
        'charset'     => 'UTF-8',
        'email'     => 'dmunioz@imps.org.ar',
        'name'     => 'dmunioz@imps.org.ar',
    )
));
