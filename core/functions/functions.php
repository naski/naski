<?php

namespace Naski;

function sumProperties(array $arr, $property)
{
    $sum = 0;
    foreach($arr as $object) {
        $sum += $object->{$property} ?? 0;
    }
    return $sum;
}

function sumCalls(array $arr, $property) {

    $sum = 0;
    foreach($arr as $object) {
        $sum += $object->{$property}();
    }
    return $sum;
}
