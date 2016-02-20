<?php

use Naski\Displayer\Bundle\BundleManager;
use Naski\Displayer\NaskiDisplayer;

BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/naskiPage/');
BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/dev_bar/');
BundleManager::getInstance()->recordBundle(NASKI_CORE_PATH.'bundles/errors/');

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
