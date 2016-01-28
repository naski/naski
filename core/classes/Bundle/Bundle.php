<?php

namespace Naski\Bundle;

abstract class Bundle
{
    public $directory; // Chemin absolue
    public $config;

    private $_vars = array();

    /**
     * Prête à l'overide
     * @return void
     */
    public function load() { }

    protected function setVariable($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    public function getVariable($key)
    {
        return $this->_vars[$key] ?? null;
    }

}
