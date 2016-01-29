<?php

/**
 * 	Permet de déclarer des constantes pour l'emplacement des fichiers ou dossiers
 *  Ne doit pas dépendre du framework
 *  Tous les chemins doivent terminer par un /.
 */

define('ROOT_SYSTEM',   __DIR__.'/../../'); // Chemin système vers la racine du projet (/var/www...)

define('PATH_LOGS',     ROOT_SYSTEM.'app/logs/');
define('PATH_CACHE',    ROOT_SYSTEM.'app/cache/');
