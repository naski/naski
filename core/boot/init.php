<?php

error_reporting(E_ALL);

$globals_needles = ['ROOT_SYSTEM', 'NASKI_CORE_PATH', 'NASKI_APP_PATH'];
foreach ($globals_needles as $v) {
    if (!defined($v)) {
        trigger_error("La globale $v n'est pas définie dans /boot.php", E_USER_ERROR);
    }
}

use Naski\Config\Config;
use Naski\InstancesManager;

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(CONFIG_FILE);

if ($IM->config['show_php_errors'] ?? false) {
    ini_set("display_errors", 1);
} else {
    ini_set("display_errors", 0);
}

// Ajout de quelques commandes à la console
\Naski\Console::getInstance()->recordCommand("cleanCache", array(new \Naski\Controllers\Backend(), 'cleanCache'));
\Naski\Console::getInstance()->recordFileExec("cleanLogs", NASKI_CORE_PATH.'scripts/clean_logs.sh');
\Naski\Console::getInstance()->recordFileExec("setPerms", NASKI_CORE_PATH.'scripts/set_perms.sh');
