<?php

namespace Naski\Bundle;

use Naski\Config\Config;

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

    private function __constuct() { }

    private function recordNewBundle(Bundle $bundle)
    {
        $this->_bundles[$bundle->config->alias] = $bundle;
    }

    public function getBundle(string $key): Bundle
    {
        return $this->_bundles[$key];
    }

    /**
     * Charge un bundle dans la mémoire pour qu'il soit accessible, mais ne l'exécute pas
     * @param  string $dirBundle Le chemin absolue vers le bundle à charger, finisant par un /
     * @return void
     */
    public function loadBundle(string $dirBundle)
    {
        $config = new Config();
        $config->loadFile($dirBundle.'config.json');

        require_once $dirBundle.'autoload.php';

        $nameClass = $config->class;

        $bundle = new $nameClass();

        $bundle->config = $config;
        $bundle->directory = $dirBundle;

        $this->recordNewBundle($bundle);
    }
}
