<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$IM = new InstancesManager();

// Monolog
{
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(PATH_LOGS . 'tests.log', Logger::WARNING));

    // add records to the log
    $log->addWarning('Foo');
    $log->addError('Bar');
}

// Connexion SQL
{
    $pdo = new DoePdo\MySQLDatabase();
    $pdo->connect($config_json['main_mysql']);
}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem(ROOT_SYSTEM . '/web/');
    $twig = new Twig_Environment($loader, array(
        'cache' => ROOT_SYSTEM . '/app/cache/',
    ));

    $IM->recordInstance('twig', $twig);
}
