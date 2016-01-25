<?php

use Naski\Config\Config;
use Naski\Routing\Routing;
use Naski\Routing\Rule;

function addRulesFromConfig(Routing &$routing, Config $config)
{
    $rules = array();
    foreach ($config['rules'] as $r) {
        $rules[] = new Rule($r);
    }

    $routing->addRules($rules, $config['subpath'] ?? '');
}


$ROUTING = new Routing();

$mainRules = new Config();
$mainRules->loadJSONFile(ROOT_SYSTEM . 'src/demo/routing.json');
addRulesFromConfig($ROUTING, $mainRules);

$path = '/' . ($_GET['route'] ?? '');
if (!$ROUTING->process($path)) {
    die('Aucune route trouvée.');
}
