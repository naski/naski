<?php

/**
 *  Instancie des entités nécessaires au projet
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Naski\Pdo\MySQLDatabase;
use Naski\InstancesManager;

$IM = new InstancesManager();

PHP_Timer::start();

// Config
{
    $CONFIG->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
    $CONFIG->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$CONFIG->env.'.json');

    $IM->recordInstance('config', $CONFIG);
}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
    $loader->addPath(ROOT_SYSTEM.'app/ressources/views/');

    $options = $CONFIG->cache_twig ? array(
        'cache' => ROOT_SYSTEM.'/app/cache/',
    ) : array();

    $twig = new Twig_Environment($loader, $options);

    $IM->recordInstance('twig', $twig);
}
