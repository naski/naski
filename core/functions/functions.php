<?php

function sumProperties(array $arr, $property) {

    $sum = 0;

    foreach($arr as $object) {
        $sum += $object->{$property}() ?? -1;
    }

    return $sum;
}
