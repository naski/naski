<?php


$CONFIG = new Config();
$CONFIG->loadConfigFile('config.json');
$CONFIG->loadConfigFile('naski/config_' . $CONFIG->env . '.json');

if ($CONFIG->show_php_errors) {
    // Démo
}
