<?php

/**
 *  Instancie des entités nécessaires au projet
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Naski\Pdo\MySQLDatabase;

PHP_Timer::start();

global $IM;

// Config
{
    $IM->config->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
    $IM->config->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config->env.'.json');

}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
    $loader->addPath(ROOT_SYSTEM.'app/ressources/views/');

    $options = $IM->config->cache_twig ? array(
        'cache' => ROOT_SYSTEM.'/app/cache/',
    ) : array();

    $IM->recordInstance('twig', new Twig_Environment($loader, $options));
}
