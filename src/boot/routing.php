<?php

use Naski\Config\Config;
use Naski\Routing\Routing;
use Naski\Routing\Rule;

function createRulesFromConfig(Config $config): array
{
    $rules = array();
    foreach ($config['rules'] as $r) {
        $rules[] = new Rule($r);
    }
    return $rules;
}

$path = '/' . ($_GET['route'] ?? '');
$ROUTING = new Routing($path);

$mainRules = new Config();
$mainRules->loadJSONFile(ROOT_SYSTEM . 'src/demo/routing.json');
$rules = createRulesFromConfig($mainRules);

$ROUTING->addRules($rules);
$ROUTING->process($path);
