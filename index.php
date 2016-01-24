<?php

// Classes des composants externes
require_once __DIR__ . '/vendor/autoload.php';

// Classes du framework et du projet
require_once __DIR__ . '/core/autoload.php';

// Initialisation du framework
require_once __DIR__ . '/core/Inits/paths.php';

$config_file = file_get_contents(ROOT_SYSTEM . 'app/config/config.json');
$config_json = json_decode($config_file, $assoc = true);

require_once __DIR__ . '/core/Inits/instances.php';


// Démo
require 'web/demo/controllers/home.php';

$ctrl = new HomeController();
$ctrl->indexAction();
