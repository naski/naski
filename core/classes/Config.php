<?php

class Config
{
    private $_array = array();

    public function __construct()
    {

    }

    /**
     *  TODO Gérer les erreurs de fichier introuvale
     */
    public function loadJSONFile(string $path)
    {
        $content = file_get_contents($path);
        $this->loadJSON($content);
    }

    private function loadJSON(string $json)
    {
        $array = json_decode($json, $assoc = true);
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

    public function toArray(): array
    {
        return $this->_array;
    }

}
