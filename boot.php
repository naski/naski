<?php

/**
 *  Fichier à inclure avant chaque utilisation du framework.
 *  Ne produit aucun affichage si tout se passe bien.
 */

 // Classes des composants externes
require_once __DIR__.'/vendor/autoload.php';

// Tests de dépendance
require_once __DIR__.'/core/boot/dependencies.php';

// Initialisation du framework
require_once __DIR__.'/core/boot/tools.php';
require_once __DIR__.'/core/boot/paths.php';
require_once __DIR__.'/core/boot/init.php';

// Initialisation du projet
require_once __DIR__.'/src/boot/instances.php';
