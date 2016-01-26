<?php

use Naski\Config\Config;
use Naski\Routing\MultiSite\MultiSite;
use League\Uri\Schemes\Http as HttpUri;

$websites = new Config();
$websites->loadJSONFile(ROOT_SYSTEM.'app/multisite.json');

$multisite = MultiSite::buildFromConfig($websites, ROOT_SYSTEM);

$uri = HttpUri::createFromServer($_SERVER);
$multisite->process($uri);
