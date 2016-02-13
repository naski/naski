<?php

use Naski\Config\Config;
use Naski\Displayer\Bundle\BundleManager;
use Naski\InstancesManager;

BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/naskiPage/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/dev_bar/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/errors/');

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/naski/'.'default.json');

$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config->env.'.json');

// Moteur de template twig
{
    $options = $IM->config->cache_twig ? array(
        'cache' => ROOT_SYSTEM.'/app/cache/',
    ) : array();
    $mainTwig = new \Naski\Displayer\MainTwig($options);
    $IM->recordInstance('twig', $mainTwig);
}

$bundle = BundleManager::getInstance()->getBundle('errors');
$bundle->exec();
