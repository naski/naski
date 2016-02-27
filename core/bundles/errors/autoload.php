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

        if (!$IM->config['show_php_errors']) {
            die();
        }

        $this->exception = $e;

        $IM->dpl->useBundle('naskiPage');
        $IM->dpl->useBundle($this->getAlias());
        $IM->dpl->render('@errors/view.twig');

        die();

    }
}
