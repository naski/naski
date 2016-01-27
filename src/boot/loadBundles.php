<?php

use Naski\Bundle\BundleManager;

$bundleManager = BundleManager::getInstance();

$paths = array(
    'dev_bar/'
);

foreach ($paths as $p) {
    $dirBundle = ROOT_SYSTEM.'core/bundles/'.$p;
    $bundleManager->loadBundle($dirBundle);
}
