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
\Naski\Console::getInstance()->recordCommand("cleanCache", array(new \Naski\Controllers\Backend(), 'cleanCache'));
\Naski\Console::getInstance()->recordFileExec("cleanLogs", NASKI_CORE_PATH.'scripts/clean_logs.sh');
\Naski\Console::getInstance()->recordFileExec("setPerms", NASKI_CORE_PATH.'scripts/set_perms.sh');

