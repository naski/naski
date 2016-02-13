<?php

namespace Naski\Displayer\Bundle;

abstract class Bundle
{
    public $directory; // Chemin absolue
    public $config;

    private $_twigParams = array();

    /**
     * Fonction écrite par convention pour les bundles qui nécesites d'être exécutés
     * Prête à l'overide
     */
    public function exec() { }

    /**
     * Appelé quand le Bundle est enregistré par le framework
     * À utilser pour initialiser ce qui est propre au bundle (variables privées...)
     * Ne pas utilser des élements du framework.
     *
     * Prêt pour override
     */
    public function onEnable() { }

    protected function addTwigParams(array $a): array
    {
        $this->_twigParams = array_merge($this->_params, $a);
    }

    public function getTwigParams(): array
    {
        return $this->_twigParams;
    }

    public function getTwigTemplatesDir()
    {
        return $this->directory.$this->config->twig_path;
    }

}
