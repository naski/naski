<?php

use Naski\Config\Config;
use Naski\Routing\Multisite\Multisite;
use League\Uri\Schemes\Http as HttpUri;

$websites = new Config();
$websites->loadFile(ROOT_SYSTEM.'src/ressources/multisite.yml');

$multisite = MultiSite::buildFromConfig($websites, ROOT_SYSTEM);
$multisite->setOnSiteHandle(function($site) {
    global $IM;
    $IM->recordInstance('site', $site);
});

$uri = HttpUri::createFromServer($_SERVER);
$multisite->process($uri);
