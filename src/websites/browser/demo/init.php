<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

require ROOT_SYSTEM_WEBSITE.'controllers/home.php';

use \Naski\Displayer\NaskiDisplayer;

global $IM;

$IM->recordInstance('site', $SITE);

$IM->dpl->addTwigPath(ROOT_SYSTEM_WEBSITE.'views/');
