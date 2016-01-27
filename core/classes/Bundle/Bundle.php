<?php

namespace Naski\Bundle;

class Bundle
{
    public $directory; // Chemin absolue
    public $config;

    public function load()
    {

    }

    protected function setVariable($key, $value)
    {
        $this->$key = $value;
    }

    public function getVariable($key)
    {
        return $this->$key;
    }

}
