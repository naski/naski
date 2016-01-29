<?php

namespace Naski\Bundle;

/**
 * Bundle qui est capable de s'intégrer dans une page web
 * Contient des templates twig, des variable twigs
 *
 * Le bundle doit etre chargé dans le MainTwig pour pouvoir être utilisé
 * 
 * // TODO et bientôt des assets...
 */
abstract class DisplayBundle extends Bundle
{

    private $_params = array();

    protected function addTwigParams(array $a): array
    {
        $this->_params = array_merge($this->_params, $a);
    }

    public function getTwigParams(): array
    {
        return $this->_params;
    }

    public function getTwigTemplatesDir()
    {
        return $this->directory.$this->config->twig_path;
    }

}
