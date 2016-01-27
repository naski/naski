<?php

use Naski\Config\Config;
use Naski\Bundle\BundleManager;

$CONFIG = new Config();
$CONFIG->loadJSONFile(ROOT_SYSTEM.'app/ressources/config/naski/'.'default.json');

BundleManager::getInstance()->loadBundle(ROOT_SYSTEM.'core/bundles/dev_bar/');
