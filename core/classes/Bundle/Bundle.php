<?php

namespace Naski\Bundle;

abstract class Bundle
{
    public $directory; // Chemin absolue
    public $config;

    /**
     * Prête à l'overide
     * @return void
     */
    public function load() { }

}
