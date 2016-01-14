<?php

// Classes des composants
require __DIR__ . '/vendor/autoload.php';

// Classes du framework et du projet
require __DIR__ . '/core/autoload.php';

// require 'vendor/doelia/pdo/src/DatabaseAbstract.class.php';
// require 'vendor/doelia/pdo/src/MySQLDatabase.php';

$IM = new InstancesManager();

// Connexion SQL
{
    $pdo = new DoePdo\MySQLDatabase();
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
