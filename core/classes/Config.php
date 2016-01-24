<?php

class Config
{
    private $_array = array();

    public function __construct()
    {

    }

    public function loadConfigFile(string $filename)
    {
        $this->loadJSONFile(ROOT_SYSTEM . 'app/config/'. $filename);
    }

    private function loadJSONFile(string $path)
    {
        $content = file_get_contents($path);
        $this->loadJSON($content);
    }

    private function loadJSON($json)
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

    public function toArray()
    {
        return $this->_array;
    }

}
