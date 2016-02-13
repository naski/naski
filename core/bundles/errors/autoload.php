<?php

/**
 * Dépendances:
 * bundle/naskiPage
 */

use Naski\Displayer\Bundle\Bundle;

class ErrorBundle extends Bundle
{
    public $exception;

    public function exec()
    {
        set_exception_handler(array($this, 'onException'));
    }

    public function onException($e)
    {
        global $IM;

        $this->exception = $e;

        $IM->twig->useBundle('naskiPage');
        $IM->twig->useBundle($this->getAlias());
        $IM->twig->render('@errors/view.twig');

        die();

    }
}
