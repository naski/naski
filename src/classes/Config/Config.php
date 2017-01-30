<?php

namespace Naski\Config;

use /** @noinspection PhpUndefinedClassInspection */
    Spyc;

class Config implements \ArrayAccess
{

    private $_subs = array();

    /**
     * Charge un fichier dans la config. L'extention est dynamiquement chargée.
     * Extentions prisent en charge : .json, .yml
     * @param  string $path Le chemin absolue du fuchier
     * @throws FileNotFoundException
     * @throws UnknownExtensionException
     */
    public function loadFile(string $path)
    {
        $tab = explode('.', $path);
        switch (end($tab) ?? '') {
            case 'yml':
                $this->loadYAMLFile($path);
                break;
            case 'json':
                $this->loadJSONFile($path);
                break;
            default:
                throw new UnknownExtensionException('Extention du fichier '.$path.' non gérée');
        }
    }

    public static function fromFile(string $path) {
        $config = new self();
        $config->loadFile($path);
        return $config;
    }

    private function loadYAMLFile(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("Le fichier YML $path est introuvale.");
        }

        try {
            /** @noinspection PhpUndefinedClassInspection */
            $data = Spyc::YAMLLoad($path);
            $this->loadArray($data);
        } catch (\Exception $e) {
            throw new FileNotFoundException($e);
        }
    }

    private function loadJSONFile(string $path)
    {
        $content = @file_get_contents($path);
        if ($content === false) {
            throw new FileNotFoundException("Le fichier JSON $path est introuvale.");
        }
        $this->loadJSON($content);
    }

    private function loadJSON(string $json)
    {
        $array = json_decode($json, $assoc = true);
        if ($array === null) {
            throw new BadJsonSynthaxeException('Le json est mal formé.');
        }
        $this->loadArray($array);
    }

    private function loadArray(array $array)
    {
        $this->_subs = array_merge($this->_subs, $array);
    }

    /**
     * Retourne l'ensemble de la hiérarchie des valeurs dans un array
     * @return array Le tableau complet
     */
    public function toArray(): array
    {
        return $this->_subs;
    }

    public function &getArrayReference() {
        return $this->_subs;
    }

    /**
    * Retoune un array ou la valeur correspondante
    * @param  string $key La clé voulue
    * @return mixed
    */
    public function get($key)
    {
        return $this->_subs[$key] ?? null;
    }

    public function __get($key)
    {
        $value = $this->get($key);
        if (is_array($value)) {
            $config = new self();
            $config->loadArray($value);
            return $config;
        } else {
            return $value;
        }
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetExists($key)
    {
        return isset($this->_subs[$key]);
    }

    public function offsetSet($offset, $value) { }

    public function offsetUnset($offset) { }


}
