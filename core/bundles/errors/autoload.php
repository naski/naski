<?php

use Naski\Bundle\DisplayBundle;

class ErrorBundle extends DisplayBundle
{
    public function load()
    {
        global $IM;
        $IM->twig->addExtension(new Twig_Extension_Debug());
    }

    protected function getTwigParamsOveride(): array
    {
        return array();
    }

    public $exceptions = array();

    public function addException($e)
    {
        $this->exceptions[] = $e;
    }
}
