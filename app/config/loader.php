<?php

$loader = new \Phalcon\Loader();

// Register some namespaces
$loader->registerNamespaces(
    array(
        "Modules"    => "../app/vendor/schedule/",
    )
);
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->formsDir,
        $config->application->libraryDir,
        $config->application->mpdfDir,
        $config->application->componentesDir,
        $config->application->curriculumDir,
        $config->application->phpmailerDir,
        $config->application->utilesDir,
        $config->application->pluginsDir,
        $config->application->vendorDir,
        $config->application->modelsDir
    )
)->register();
