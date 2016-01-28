<?php

namespace Naski\Config;

class Config implements \ArrayAccess
{

    private $_subs = array();

    /**
     * Charge un fichier dans la config. L'extention est dynamiquement chargée.
     * Extentions prisent en charge : .json, .yml
     * @param  string $path Le chemin absolue du fuchier
     * @return void
     */
    public function loadFile(string $path)
    {
        $tab = explode('.', $path);
        switch (end($tab) ?? '') {
            case 'yml':
                return $this->loadYAMLFile($path);
                break;
            case 'json':
                return $this->loadJSONFile($path);
                break;
            default:
                throw new UnknownExtensionException('Extention du fichier '.$path.' non gérée');
        }
    }

    private function loadYAMLFile(string $path)
    {
        try {
            $data = \Spyc::YAMLLoad($path);
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

    /**
    * Peut retourner une nouvelle sous config, la valeur, ou '' si la clé n'existe pas
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

    public function offsetExists($offset) {
        return isset($this->_subs[$key]);
    }

    public function offsetSet($offset, $value) { }

    public function offsetUnset($offset) { }


}
