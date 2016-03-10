<?php

namespace Naski;

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

function array_keep(array $array, array $listKeys)
{
    $out = array();
    foreach ($array as $key => $value) {
        if (in_array($key, $listKeys, true)) {
            $out[$key] = $value;
        }
    }
    return $out;
}
