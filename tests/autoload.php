<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

define('ROOT_SYSTEM', __DIR__.'/');
define('NASKI_CORE_PATH', __DIR__.'/../core/');
define('NASKI_APP_PATH', __DIR__.'/app/');

trigger_error('boom');

// Classes des composants externes
if (!require_once __DIR__.'/../vendor/autoload.php') {
    trigger_error('Exécuter `composer install` pour télécharger le vendor/');
}

// Initialisation du framework
require_once NASKI_CORE_PATH.'boot/init.php';
