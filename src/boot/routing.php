<?php

use Naski\Config\Config;

$routing = new Config();
$routing->loadJSONFile(ROOT_SYSTEM . 'src/demo/routing.json');

foreach ($routing['rules'] as $rule) {
    $type = $rule['type'] ?? 'any';
    $MUX->$type($rule['path'], [$rule['controller'], $rule['method']]);
}
