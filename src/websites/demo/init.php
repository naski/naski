<?php

require ROOT_SYSTEM.'src/websites/demo/controllers/home.php';

global $IM;

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

$IM->twig->getLoader()->addPath(ROOT_SYSTEM_WEBSITE.'views/');
