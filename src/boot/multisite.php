<?php

use Naski\Config\Config;
use Naski\Routing\MultiSite\MultiSite;

$websites = new Config();
$websites->loadJSONFile(ROOT_SYSTEM . 'app/multisite.json');

$multisite = MultiSite::buildFromConfig($websites, ROOT_SYSTEM);

$path = '/' . ($_GET['route'] ?? '');
$multisite->process('', $path);
