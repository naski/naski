<?php

use Pux\Executor;
use Naski\Routing\Routing;

require_once 'boot.php';

// Démo

require '../src/demo/controllers/home.php';

$_POST = $GUMP->sanitize($_POST);

$ROUTING = new Routing();

require '../src/boot/routing.php';

// require_once '../core/debug_bar/show.php';
