<?php

namespace Naski\Bundle;

abstract class Bundle
{
    public $directory; // Chemin absolue
    public $config;

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

}
