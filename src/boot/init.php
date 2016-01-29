<?php

/**
 *  Instancie des entités nécessaires au projet
 *  Ne doit pas faire d'affichage
 */

PHP_Timer::start();

global $IM;

// Config
{
    $IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
    $IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config->env.'.json');
}
