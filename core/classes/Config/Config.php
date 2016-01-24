<?php

namespace Naski\Config;

class Config implements \ArrayAccess
{
    private $_array = array();
    private static $DEFAULT_VALUE = ""; // Valeur retournée si la clé demandée n'existe pas

    /**
     *  TODO Gérer les erreurs de fichier introuvale
     */
    public function loadJSONFile(string $path)
    {
        $content = file_get_contents($path);
        $this->loadJSON($content);
    }

    /**
     *  TODO Vérifier la validité du JSON
     */
    private function loadJSON(string $json)
    {
        $array = json_decode($json, $assoc = true);
        // echo "load... $json";
        $array = $array ?? array();
        $this->loadArray($array);
    }

    private function loadArray(array $array)
    {
        $this->_array = array_merge($this->_array, $array);
        foreach ($array as $key => $value) {
            $attr = "$key";
            if (is_array($value)) {
                $this->$attr = new Config();
                $this->$attr->loadArray($value);
            } else {
                $this->$attr = $value;
            }
        }
    }

    public function __get($key)
    {
        return $this->$key ?? self::$DEFAULT_VALUE;
    }

    public function offsetGet($offset)
    {
        return $this->_array[$offset] ?? self::$DEFAULT_VALUE;
    }

    public function offsetSet($offset, $value) { }

    public function offsetExists($offset) { }

    public function offsetUnset($offset) { }


}
