<?php

use Naski\Config\Config;
use Naski\Routing\Rule;

$mainRules = new Config();
$mainRules->loadJSONFile(ROOT_SYSTEM . 'src/demo/routing.json');

$rules = Rule::createRulesFromConfig($mainRules);

$ROUTING->addRules($rules);

$path = '/' . ($_GET['route'] ?? '');
$ROUTING->process($path);
