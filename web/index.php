<?php

use Pux\Executor;

require_once 'boot.php';

// Démo

require '../src/demo/controllers/home.php';

$MUX = new Pux\Mux;

require '../src/boot/routing.php';

// require_once '../core/debug_bar/show.php';

$path = '/' . ($_GET['route'] ?? '');
$route = $MUX->dispatch($path);

if ($route == null) {
    die("Page '$path' introuvable");
} else {
    echo Executor::execute($route);
}
