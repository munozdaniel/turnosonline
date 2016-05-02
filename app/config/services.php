<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));
            $volt->getCompiler()->addFunction('is_a', 'is_a');
            $volt->getCompiler()->addFunction('base64', 'base64_encode');
            $volt->getCompiler()->addFilter('strtotime', 'strtotime');

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**=========================================================================================
 * Database connection is created based in the parameters defined in the configuration file
 ===========================================================================================*/
$di->set('db', function () use ($config) {
    return new DbAdapter($config->database->toArray());
});
//GESTIONUSUARIOS
$di->set('dbUsuarios', function () use ($config) {
    return new DbAdapter($config->gestionusuarios->toArray());

});
//SUJYPWEB
$di->set('dbSujypweb', function () use ($config) {
    return new DbAdapter($config->sujypweb->toArray());

});

//SIPREA
$di->set('dbSiprea', function () use ($config) {
    return new DbAdapter($config->siprea->toArray());

});
/**=========================================================================================
 *
 ===========================================================================================*/
/*Esto hace falta? ??? ?? ?? */
$di->set('modelsManager', function(){
    return new Phalcon\Mvc\Model\Manager();
});
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->setOptions(array('max_execution_time'=>300));//? no funciona
    $session->start();

    return $session;
});


/**
 * Configuracion inicial para enviar email con PHPMailer a la casilla de consultas.
 */
$di->set('mail', function () use ($config) {
    //sleep(2);
    //require "../libraries/PHPMailer/PHPMailer.php";
    $mail = new PHPMailer;
    //Muestra Mensajes de error con detalles 3 o 4.
    //$mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->isHTML(true);

    $mail->CharSet      = $config->mail->charset;
    $mail->Host         = $config->mail->host;
    $mail->SMTPAuth     = true;
    $mail->Username     = $config->mail->username;
    $mail->Password     = $config->mail->password;
    $mail->SMTPSecure   = $config->mail->security;
    $mail->Port         = $config->mail->port;
//    $mail->addAddress($config->mail->email, $config->mail->name);

    return $mail;
});
/** Para enviar email a la casilla de Desarrollo */
$di->set('mailDesarrollo',function() use ($config)
{
    $mailDesarrollo = new PHPMailer;
    $mailDesarrollo->isSMTP();
    $mailDesarrollo->isHTML(true);

    $mailDesarrollo->CharSet      = $config->mailDesarrollo->charset;
    $mailDesarrollo->Host         = $config->mailDesarrollo->host;
    $mailDesarrollo->SMTPAuth     = true;
    $mailDesarrollo->Username     = $config->mailDesarrollo->username;
    $mailDesarrollo->Password     = $config->mailDesarrollo->password;
    $mailDesarrollo->SMTPSecure   = $config->mailDesarrollo->security;
    $mailDesarrollo->Port         = $config->mailDesarrollo->port;
    $mailDesarrollo->From         = $config->mailDesarrollo->email;
    $mailDesarrollo->FromName     = $config->mailDesarrollo->name;

    return $mailDesarrollo;
});
/* Usar mailDesarrollo para los turnos.
$di->set('mailInformatica', function () use ($config) {

    $mailInformatica = new PHPMailer;
    $mailInformatica->isSMTP();
    $mailInformatica->isHTML(true);

    $mailInformatica->CharSet      = $config->mailInformatica->charset;
    $mailInformatica->Host         = $config->mailInformatica->host;
    $mailInformatica->SMTPAuth     = true;
    $mailInformatica->Username     = $config->mailInformatica->username;
    $mailInformatica->Password     = $config->mailInformatica->password;
    $mailInformatica->SMTPSecure   = $config->mailInformatica->security;
    $mailInformatica->Port         = $config->mailInformatica->port;
    $mailInformatica->From         = $config->mailInformatica->email;
    $mailInformatica->FromName     = $config->mailInformatica->name;

    return $mailInformatica;
});
*/
/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function()
{
    return new Phalcon\Flash\Direct(array(
        'error'     => 'problema',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info ',
        'validador'    => 'mi-alert alert-validador ',
        'problema'    => 'problema',
        'exito'    => 'exito',
        'aviso'    => 'aviso',
        'warning'   => 'alert alert-warning ',
        'dismiss'=>'alert alert-info alert-dismissible fade in'
    ));
});
$di->set('flashSession', function()
{
    return new Phalcon\Flash\Session(array(
        'error'     => 'problema',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info ',
        'validador'    => 'mi-alert alert-validador ',
        'problema'    => 'problema',
        'exito'    => 'exito',
        'aviso'    => 'aviso',
        'warning'   => 'alert alert-warning ',
        'dismiss'=>'alert alert-info alert-dismissible fade in'
    ));
});
/**
 * Register a user component
 */
$di->set('elemento', function(){
    return new Elementos();
});
/**
 * Registramos el gestor de eventos (Utilizado en plugins/Seguridad.php)
 */
$di->set('dispatcher', function() use ($di)
{
    $eventsManager = $di->getShared('eventsManager');

    $roles = new Seguridad($di);

    /**
     * Escuchamos eventos en el componente dispatcher usando el plugin Roles
     */
    $eventsManager->attach('dispatch', $roles);

    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->set('datetime', function () use ($config) {
    return new \Modules\Datetime($config->datetime);
}, true);

$di->set('schedule', function () {
    return new \Modules\Schedule();
}, true);