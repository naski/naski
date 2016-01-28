<?php

namespace Naski\Bundle;

abstract class Bundle
{
    public $directory; // Chemin absolue
    public $config;

    protected function setVariable($key, $value)
    {
        $this->$key = $value;
    }

    public function getVariable($key)
    {
        return $this->$key;
    }

    public function addHisTemplatesToTwig($twig)
    {
        $pathTwig = $this->directory.$this->config->twig_path;
        $twig->getLoader()->addPath($pathTwig, $this->config->alias);
    }

}
