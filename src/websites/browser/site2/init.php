<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

global $IM;

$IM->recordInstance('site', $SITE);

$IM->twig->addTwigPath(ROOT_SYSTEM_WEBSITE);
$IM->twig->useBundle('devBar');
$IM->twig->render('index.twig');
