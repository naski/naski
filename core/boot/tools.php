<?php

/**
 * Permet de déclarer des racourcis à partir des variables d'environnement de PHP
 * Ne doit pas dépendre du framework
 */

 // Si l'appelant vient une requette http(s) ou si c'est une requette système (ligne de commande, cron...)
 // TODO Implémenter
define('IS_HTTP', true);
