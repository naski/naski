<?php


$CONFIG = new Config();
$CONFIG->loadJSONFile(ROOT_SYSTEM . 'app/config/naski/'. 'default.json');

if ($CONFIG->show_php_errors) {
    // Démo
}
