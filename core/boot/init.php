<?php

use Naski\Config\Config;
use Naski\Displayer\Bundle\BundleManager;
use Naski\Displayer\NaskiDisplayer;
use Naski\InstancesManager;

BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/naskiPage/');
BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/dev_bar/');
BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/errors/');

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(NASKI_CORE_PATH.'ressources/config_default.json');

$IM->config->loadFile(NASKI_APP_PATH.'ressources/config/'.'config.json');
$IM->config->loadFile(NASKI_APP_PATH.'ressources/config/'.'config_'.$IM->config['env'].'.json');

// Configuration de l'afficheur HTML
{
    $options = $IM->config['cache_twig'] ? array(
        'cache' => NASKI_APP_PATH.'cache/twig/',
    ) : array();
    $IM->recordInstance('dpl', new NaskiDisplayer($options));
    $IM->dpl->useBundle('devBar');
}

$bundle = BundleManager::getInstance()->getBundle('errors');
$bundle->exec();
