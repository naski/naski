<?php


$CONFIG = new Config();
$CONFIG->loadJSONFile(ROOT_SYSTEM . 'app/config/'. 'config.json');
$CONFIG->loadJSONFile(ROOT_SYSTEM . 'app/config/'. 'naski/config_' . $CONFIG->env . '.json');

if ($CONFIG->show_php_errors) {
    // Démo
}
