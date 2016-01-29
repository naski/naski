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
    public function load()
    {
        global $IM;
        $IM->twig->getTwigInstance()->addExtension(new Twig_Extension_Debug());
        set_exception_handler(array($this, 'onException'));
    }

    public $exception;

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
