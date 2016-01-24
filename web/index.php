<?php

require_once __DIR__ . '/../core/Boot/dependencies.php';

// Classes des composants externes
require_once __DIR__ . '/../vendor/autoload.php';

// Classes du framework et du projet
require_once __DIR__ . '/../core/autoload.php';

// Initialisation du framework
require_once __DIR__ . '/../core/Boot/tools.php';
require_once __DIR__ . '/../core/Boot/paths.php';

require_once __DIR__ . '/../core/Boot/instances.php';


// Démo

require '../src/demo/controllers/home.php';

$ctrl = new HomeController();
$ctrl->indexAction();
