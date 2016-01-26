<?php

use Naski\Config\Config;
use Naski\Routing\Routing;
use Naski\Routing\Rule;

$path = '/' . ($_GET['route'] ?? '');

$websitesJson = '
{
    "rootPath": "src/websites/",
    "websites": [
        {
            "name": "Site 2",
            "access": {
                "path": "^/site2(.*)"
            },
            "src": "site2/",
            "initFile": "init.php"
        },
        {
            "demo": "Démo",
            "src": "demo/",
            "initFile": "init.php",
            "router": "routing.json"
        }
    ]
}
';


$websites = new Config();
$websites->loadJSON($websitesJson);

$rootDir = ROOT_SYSTEM . $websites['rootPath'];
foreach ($websites['websites'] as $w) {

    $useThis = true;
    if ($w['access']['path'] ?? '') {
        $regex = '#' . $w['access']['path'] . "#";
        $result = preg_replace($regex, '${1}', $path);
        if ($result != $path) {
            $path = $result;
        } else {
            $useThis = false;
        }
    }

    if ($useThis) {
        require $rootDir . $w['src'] . $w['initFile'];

        if ($w['router'] ?? '') {
            $routingFile = $rootDir . $w['src'] . $w['router'];
            $routing = new Routing();
            $routing->addRules(Naski\getRulesFromJsonFile($routingFile));

            if (!$routing->process($path)) {
                die('Aucune route trouvée.');
            }
        }

        exit();
    }

}

die('Aucun site trouvé.');
