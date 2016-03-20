<?php

<<<<<<< HEAD
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
global $IM;
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
\Naski\Console::getInstance()->recordCommand("cleanLogs", array(new \Naski\Controllers\Backend(), 'cleanLogs'));
\Naski\Console::getInstance()->recordCommand("clearAssets", function() {
    echo exec("rm -rf ".ROOT_SYSTEM.'web/generated_assets');
});
\Naski\Console::getInstance()->recordFileExec("setPerms", NASKI_CORE_PATH.'scripts/set_perms.sh');
=======
use Naski\Config\Config;
use Naski\Displayer\Bundle\BundleManager;
use Naski\Displayer\NaskiDisplayer;
use Naski\InstancesManager;

BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/naskiPage/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/dev_bar/');
BundleManager::getInstance()->recordBundle(ROOT_SYSTEM.'core/bundles/errors/');

// Variable globale contenant toutes les instances à déclarer comme globales
$IM = new InstancesManager();

$IM->recordInstance('config', new Config());
$IM->config->loadFile(ROOT_SYSTEM.'core/ressources/config_default.json');

$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config.json');
$IM->config->loadFile(ROOT_SYSTEM.'app/ressources/config/'.'config_'.$IM->config['env'].'.json');

// Configuration de l'afficheur HTML
{
    $options = $IM->config['cache_twig'] ? array(
        'cache' => PATH_CACHE,
    ) : array();
    $IM->recordInstance('dpl', new NaskiDisplayer($options));
    $IM->dpl->useBundle('devBar');
}

$bundle = BundleManager::getInstance()->getBundle('errors');
$bundle->exec();
>>>>>>> demo/master
