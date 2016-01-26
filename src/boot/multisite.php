<?php

use Naski\Config\Config;
use Webmozart\Json\JsonValidator;

$path = '/' . ($_GET['route'] ?? '');

$websitesJson = '
{
    "rootPath": "src/websites/"
    "websites": [
        {
            "name": "Site 2",
            "access": {
                "path": "^/site2/(.*)"
            },
            "src": "site2/",
            "initFile": "init.php",
            "controllers": "controllers/",
            "router": "routing.json"
        }
    ]
}
';


$websites = new Config();
$websites->loadJSON($websitesJson);

$validator = new JsonValidator();
$errors = $validator->validate($websites->toArray(), ROOT_SYSTEM . 'core/multisite-schema.json');

if (count($errors) > 0) {
    echo "bbbd";
}

var_dump($websites);

$rootDir = ROOT_SYSTEM . $websites['rootPath'];
foreach ($websites['websites'] as $w) {
    if (($result = preg_replace('#' . $w['access']['path'] . "#", '${1}', $path)) != $path) {
        $path = $result;
        require $rootDir . $w['src'] . $w['initFile'];
    }
}
