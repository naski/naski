<?php

define('ROOT_SYSTEM', __DIR__.'/');
define('NASKI_CORE_PATH', __DIR__.'/../core/');
define('NASKI_APP_PATH', __DIR__.'/app/');

// Configuration de l'environnement
ini_set("display_errors", 1); // Sera écrasé par la config, présent pour les tests du framework
define('CONFIG_FILE', NASKI_CORE_PATH.'ressources/config_examples/dev.yml');

// Classes des composants externes
if (!require_once __DIR__.'/../vendor/autoload.php') {
    trigger_error('Exécuter `composer install` pour télécharger le vendor/', E_USER_ERROR);
}

// Initialisation du framework
require_once NASKI_CORE_PATH.'boot/init.php';
