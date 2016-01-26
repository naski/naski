<?php

namespace Naski;

use Naski\Config\Config;
use Naski\Routing\Rule;

function getRulesFromJsonFile(string $filename): array
{
    $config = new Config();
    $config->loadJSONFile($filename);
    $rules = array();
    foreach ($config['rules'] as $r) {
        $rules[] = new Rule($r);
    }
    return $rules;
}
