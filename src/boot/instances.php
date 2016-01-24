<?php

/**
 *  Instancie des entités nécessaires au projet
 *  Dépend de paths.php et tools.php
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use DoePdo\MySQLDatabase;

$IM = new InstancesManager();

// Config
{
    $CONFIG->loadJSONFile(ROOT_SYSTEM . 'app/config/'. 'config.json');
    $CONFIG->loadJSONFile(ROOT_SYSTEM . 'app/config/'. 'config_' . $CONFIG->env . '.json');

    $IM->recordInstance('config', $CONFIG);
}

// Monolog
{
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(PATH_LOGS . 'tests.log', Logger::WARNING));

    $log->addWarning('Foo', array('username' => 'Seldaek'));
    $log->addError('Bar');

}

// Connexion SQL
{
    $log = new Logger('mysql');
    $log->pushHandler(new StreamHandler(PATH_LOGS . 'mysql.log'));

    $pdo = new MySQLDatabase($CONFIG->main_mysql->toArray(), $log);
    $pdo->forceConnect();

}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem($basepath = ROOT_SYSTEM . '/src/');

    $options = $CONFIG->cache_twig ? array(
        'cache' => ROOT_SYSTEM . '/app/cache/',
    ) : array();

    $twig = new Twig_Environment($loader, $options);

    $IM->recordInstance('twig', $twig);
}
