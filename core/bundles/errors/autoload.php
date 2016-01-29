<?php

/**
 * Dépendances:
 * $IM->twig
 * bundle/devBar
 */

use Naski\Bundle\DisplayBundle;
use Naski\Bundle\BundleManager;

class ErrorBundle extends DisplayBundle
{
    public $exception;

    public function load()
    {
        global $IM;
        set_exception_handler(array($this, 'onException'));
    }

    public function onException($e)
    {
        global $IM;

        $this->exception = $e;

        $bundle = BundleManager::getInstance()->getBundle('devBar');
        $bundle->load();

        $IM->twig->loadBundle($this);
        $IM->twig->loadBundle($bundle);
        $IM->twig->render('@errors/view.twig');

        die();

    }
}
