<?php

/**
 *  Fichier à inclure avant chaque utilisation du framework.
 *  Ne produit aucun affichage si tout se passe bien.
 */

// Tests de dépendance
require_once __DIR__ . '/../core/boot/1.dependencies.php';

// Classes des composants externes
require_once __DIR__ . '/../vendor/autoload.php';

// Classes du framework
require_once __DIR__ . '/../core/classes/3.autoload.php';

// Fonctions du framework
require_once __DIR__ . '/../core/functions/4.autoload.php';

// Initialisation du framework
require_once __DIR__ . '/../core/boot/5.tools.php';
require_once __DIR__ . '/../core/boot/6.paths.php';
require_once __DIR__ . '/../core/boot/7.init.php';

// Classes du projet
require_once __DIR__ . '/../src/classes/autoload.php';

// Initialisation du projet
require_once __DIR__ . '/../src/boot/instances.php';
