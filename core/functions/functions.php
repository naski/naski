<?php

namespace Naski;

use Naski\Config\Config;
use Naski\Routing\Rule;

function sumProperties(array $arr, $property)
{
    $sum = 0;
    foreach ($arr as $object) {
        $sum += $object->{$property} ?? 0;
    }
    return $sum;
}

function sumCalls(array $arr, $property)
{
    $sum = 0;
    foreach ($arr as $object) {
        $sum += $object->{$property}();
    }
    return $sum;
}

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
