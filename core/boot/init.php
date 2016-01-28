<?php

use Naski\Config\Config;
use Naski\Bundle\BundleManager;
use Naski\InstancesManager;

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/naski/'.'default.json');

BundleManager::getInstance()->loadBundle(ROOT_SYSTEM.'core/bundles/dev_bar/');
