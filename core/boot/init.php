<?php

use Naski\Config\Config;
use Naski\Displayer\Bundle\BundleManager;
use Naski\Displayer\NaskiDisplayer;
use Naski\InstancesManager;

BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/naskiPage/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/dev_bar/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/errors/');

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(ROOT_SYSTEM.'core/ressources/config_default.json');

$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config['env'].'.json');

// Configuration de l'afficheur HTML
{
    $options = $IM->config['cache_twig'] ? array(
        'cache' => PATH_CACHE,
    ) : array();
    $IM->recordInstance('dpl', new NaskiDisplayer($options));
    $IM->dpl->useBundle('devBar');
}

$bundle = BundleManager::getInstance()->getBundle('errors');
$bundle->exec();
