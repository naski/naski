<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

require ROOT_SYSTEM_WEBSITE.'controllers/home.php';

global $IM;

$IM->twig->getLoader()->addPath(ROOT_SYSTEM_WEBSITE.'views/');
