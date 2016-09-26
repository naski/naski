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

define('BIG_INT', 987654321);


// Variable globale contenant toutes les instances à déclarer comme globales
global $IM;
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(NASKI_CORE_PATH.'ressources/config_default.yml');
{
    $userNaskiConfig = \Naski\getFileInParents(ROOT_SYSTEM, 'naski_config.yml');
    if ($userNaskiConfig != null) {
        $IM->config->loadFile($userNaskiConfig);
    }

}

if ($IM->config['show_php_errors'] ?? false) {
    ini_set("display_errors", 1);
} else {
    ini_set("display_errors", 0);
}
