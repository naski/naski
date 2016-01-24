<?php

/**
 *  Instancie des entités nécessaires au framework
 *  Dépend de paths.php et tools.php
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use DoePdo\MySQLDatabase;

$config_file = file_get_contents(ROOT_SYSTEM . 'app/config/config.json');
$config_json = json_decode($config_file, $assoc = true);

$IM = new InstancesManager();

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

    $pdo = new MySQLDatabase($config_json['main_mysql'], $log);
    $pdo->forceConnect();

}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem(ROOT_SYSTEM . '/web/');
    $twig = new Twig_Environment($loader, array(
        'cache' => ROOT_SYSTEM . '/app/cache/',
    ));

    $IM->recordInstance('twig', $twig);
}
