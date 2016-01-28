<?php

namespace Naski\Config;

class Config implements \ArrayAccess
{

    private $_subs = array(); // Sous objects Config

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
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->_subs[$key] = new Config();
                $this->_subs[$key]->loadArray($value);
            } else {
                $this->_subs[$key] = $value;
            }
        }
    }

    /**
     * Convertit l'ensemble de la hiérarchie des valeurs dans un tableau
     * @return array Le tableau complet
     */
    public function toArray(): array
    {
        $a = array();
        foreach ($this->_subs as $key => $value) {
            $a[$key] = ($value instanceof Config) ? $value->toArray() : $value;
        }
        return $a;
    }

    /**
    * Peut retourner une nouvelle sous config, la valeur, ou '' si la clé n'existe pas
    * @param  string $key La clé voulue
    * @return mixed
    */
    public function get($key)
    {
        return $this->_subs[$key] ?? new NullValue();
    }

    public function __get($key)
    {
        return $this->get($key);
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
