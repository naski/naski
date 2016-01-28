<?php

use Naski\Config\Config;
use Naski\Routing\Multisite\Multisite;
use League\Uri\Schemes\Http as HttpUri;

$websites = new Config();
$websites->loadJSONFile(ROOT_SYSTEM.'app/ressources/multisite.json');

$multisite = MultiSite::buildFromConfig($websites, ROOT_SYSTEM);

$uri = HttpUri::createFromServer($_SERVER);
$multisite->process($uri);
