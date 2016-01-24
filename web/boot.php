<?php

/**
 *  Fichier à inclure avant chaque utilisation du framework.
 *  Ne produit aucun affichage si tout se passe bien.
 */

// Tests de dépendance
require_once __DIR__ . '/../core/Boot/dependencies.php';

// Classes des composants externes
require_once __DIR__ . '/../vendor/autoload.php';

// Classes du framework et du projet
require_once __DIR__ . '/../core/autoload.php';

// Initialisation du framework
require_once __DIR__ . '/../core/Boot/tools.php';
require_once __DIR__ . '/../core/Boot/paths.php';
require_once __DIR__ . '/../core/Boot/instances.php';
