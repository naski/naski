<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

global $IM;

$IM->recordInstance('site', $SITE);

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\AssetWriter;
use Assetic\FilterManager;
use Assetic\Filter\Sass\SassFilter;
use Assetic\Filter\Yui;
use Assetic\AssetManager;


$js = new AssetCollection(array(
    new FileAsset(ROOT_SYSTEM_WEBSITE.'hey.css')
));


// the code is merged when the asset is dumped
echo $js->dump();

$IM->twig->addTwigPath(ROOT_SYSTEM_WEBSITE);
$IM->twig->useBundle('devBar');
$IM->twig->render('index.twig');
