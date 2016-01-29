<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

global $IM;

$IM->recordInstance('site', $SITE);

use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\LessFilter;
use Assetic\AssetWriter;
use Assetic\FilterManager;
use Assetic\Filter\Sass\SassFilter;
use Assetic\Filter\Yui;
use Assetic\AssetManager;


$IM->twig->addTwigPath(ROOT_SYSTEM_WEBSITE);

$IM->twig->useBundle('naskiPage');
$IM->twig->render('index.twig');
