<?php

/**
 * Point d'entrée pour exécuter des scripts en shell
 * Certains scripts sont déclarés dans le core de Naski (nettoyeur de cache, logs...)
 *
 * Utilisation : php console.php [arguments]
 */

ini_set('display_errors', 1);

require(__DIR__.'/boot.php');

use Naski\Console;

Console::getInstance()->process($argv);
