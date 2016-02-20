<?php

use Naski\Config\Config;
use Naski\InstancesManager;

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(NASKI_CORE_PATH.'ressources/config_default.json');

$IM->config->loadFile(NASKI_APP_PATH.'ressources/config/'.'config.json');
$IM->config->loadFile(NASKI_APP_PATH.'ressources/config/'.'config_'.$IM->config['env'].'.json');

// Configuration de la console
\Naski\Console::getInstance()->recordCommand("cleanCache", NASKI_CORE_PATH.'scripts/clean_cache.sh');
\Naski\Console::getInstance()->recordCommand("cleanLogs", NASKI_CORE_PATH.'scripts/clean_logs.sh');
\Naski\Console::getInstance()->recordCommand("setPerms", NASKI_CORE_PATH.'scripts/set_perms.sh');

