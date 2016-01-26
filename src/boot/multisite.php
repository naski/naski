<?php

$path = '/' . ($_GET['route'] ?? '');

$exploded = explode('/', $path);

$firtPart = $exploded[1] ?? '';

if ($firtPart == 'site2') {
    $newArray = array_slice($exploded, 2);
    $path = implode('/', $exploded);
    require ROOT_SYSTEM . 'src/websites/' . $firtPart . '/init.php';
} else {
    $path = $path;
    require ROOT_SYSTEM . 'src/websites/' . 'demo' . '/init.php';
}
