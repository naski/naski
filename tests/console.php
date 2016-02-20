<?php

/**
 * Point d'entrée pour exécuter des scripts en shell
 * Certains scripts sont déclarés dans le core de Naski (nettoyeur de cache, logs...)
 *
 * Utilisation : php console.php [arguments]
 */

require(__DIR__.'/autoload.php');

use Naski\Console;

Console::getInstance()->process($argv);
