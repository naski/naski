<?php

/**
 * Dépendances:
 * bundle/naskiPage
 */

use Naski\Bundle\DisplayBundle;
use Naski\Bundle\BundleManager;

class ErrorBundle extends DisplayBundle
{
    public $exception;

    public function exec()
    {
        global $IM;
        set_exception_handler(array($this, 'onException'));
    }

    public function onException($e)
    {
        global $IM;

        $this->exception = $e;

        $IM->twig->useBundle('naskiPage');
        $IM->twig->loadBundle($this);
        $IM->twig->render('@errors/view.twig');

        die();

    }
}
