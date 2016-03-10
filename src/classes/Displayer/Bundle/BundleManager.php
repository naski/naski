<?php

namespace Naski\Displayer\Bundle;

use Naski\Config\Config;

/**
 * Gére un ensemble de Bundle
 */
class BundleManager
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BundleManager();
        }

        return self::$instance;
    }

    private $_bundles = array(); // array<Bundle>
    public $recordedBundlesStack = array();

    private function recordNewBundle(Bundle $bundle)
    {
        $this->_bundles[$bundle->getAlias()] = $bundle;
        $this->recordedBundlesStack[] = $bundle->getAlias();
    }

    public function getBundle(string $key): Bundle
    {
        if (!isset($this->_bundles[$key])) {
            throw new \Exception('Le bundle '.$key.' est introuvable parmi ceux enregistrés');
        }
        return $this->_bundles[$key];
    }

    /**
     * Enregistre un bundle dans la mémoire pour qu'il soit accessible et pour tester son fonctionnement, mais ne l'exécute pas
     * @param  string $dirBundle Le chemin absolue vers le bundle à charger, finisant par un /
     * @return Bundle   Le bundle créé
     */
    public function recordBundle(string $dirBundle): Bundle
    {
        $config = new Config();
        $config->loadFile($dirBundle.'config.yml');

        /** @noinspection PhpIncludeInspection */
        require_once $dirBundle.'autoload.php';

        $nameClass = $config['class'];

        $bundle = new $nameClass($dirBundle);

        $bundle->config = $config;
        $bundle->directory = $dirBundle;

        $this->recordNewBundle($bundle);

        /** @noinspection PhpUndefinedMethodInspection */
        $bundle->onEnable();

        return $bundle;
    }
}