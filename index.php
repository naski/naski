<?php

// Classes des composants
require_once __DIR__ . '/vendor/autoload.php';

// Classes du framework et du projet
require_once __DIR__ . '/core/autoload.php';

$IM = new InstancesManager();

define('ROOT_SYSTEM', __DIR__ . '/'); // Avec / à la fin

$config_file = file_get_contents(ROOT_SYSTEM . 'app/config/config.json');
$config_json = json_decode($config_file, $assoc = true);

// Connexion SQL
{
    $pdo = new DoePdo\MySQLDatabase();
    $pdo->connect($config_json['main_mysql']);
}

// Moteur de template twig
{
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/web/');
    $twig = new Twig_Environment($loader, array(
        'cache' => __DIR__ . '/app/cache/',
    ));

    $IM->recordInstance('twig', $twig);
}

// Démo
require 'web/demo/controllers/home.php';

$ctrl = new HomeController();
$ctrl->indexAction();
