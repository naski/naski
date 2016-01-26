<?php

use Naski\Config\Config;
use Naski\Routing\MultiSite\MultiSite;

$websitesJson = '
{
    "rootPath": "src/websites/",
    "websites": [
        {
            "name": "Site 2",
            "conditions": {
                "path": "^/site2(.*)"
            },
            "initFile": "site2/init.php"
        },
        {
            "name": "Démo",
            "initFile": "demo/init.php",
            "routingFile": "demo/routing.json"
        }
    ]
}
';

$websites = new Config();
$websites->loadJSON($websitesJson);

$multisite = MultiSite::buildFromConfig($websites, ROOT_SYSTEM);

$path = '/' . ($_GET['route'] ?? '');
$multisite->process('', $path);
