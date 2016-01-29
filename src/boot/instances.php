<?php

/**
 *  Instancie des entités nécessaires au projet
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Naski\Pdo\MySQLDatabase;
use Naski\Bundle\BundleManager;

PHP_Timer::start();

global $IM;

// Config
{
    $IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
    $IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config->env.'.json');
}
