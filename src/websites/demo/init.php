<?php

use Naski\Config\Config;
use Naski\Routing\Routing;
use Naski\Routing\Rule;

require ROOT_SYSTEM . 'src/websites/demo/controllers/home.php';

function addRulesFromConfig(Routing &$routing, Config $config)
{
    $rules = array();
    foreach ($config['rules'] as $r) {
        $rules[] = new Rule($r);
    }
    $routing->addRules($rules);
}


$ROUTING = new Routing();

$mainRules = new Config();
$mainRules->loadJSONFile(ROOT_SYSTEM . 'src/websites/demo/routing.json');
addRulesFromConfig($ROUTING, $mainRules);

if (!$ROUTING->process($path)) {
    die('Aucune route trouvée.');
}
