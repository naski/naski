<?php

/**
 *  Instancie des entités nécessaires au projet
 *  Dépend de paths.php et tools.php.
 */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Naski\Pdo\MySQLDatabase;
use Naski\InstancesManager;

$IM = new InstancesManager();

// Config
{
    $CONFIG->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
    $CONFIG->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$CONFIG->env.'.json');

    $IM->recordInstance('config', $CONFIG);
}

// Monolog
{
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(PATH_LOGS.'tests.log', Logger::WARNING));

    $log->addWarning('Foo', array('username' => 'Seldaek'));
    $log->addError('Bar');

}

// Connexion SQL
{
    $log = new Logger('mysql');
    $log->pushHandler(new StreamHandler(PATH_LOGS.'mysql.log'));

    $pdo = new MySQLDatabase($CONFIG['main_mysql'], $log);

    $pdo->query("SELECT 'foo'");

    $IM->recordDatabaseInstance('main_mysql', $pdo);

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
