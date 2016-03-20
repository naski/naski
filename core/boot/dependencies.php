<?php

/**
 *  Permet de tester les modules nécessaires
 *  S'execute en tout premier, ne doit pas dépendendre du framework.
 */

if (version_compare(phpversion(), '7.0.0', '<')) {
    die('PHP 7.0.0 doit être installé. Version actuelle : '.phpversion());
}
