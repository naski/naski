<?php

/**
 * Bundle pour créer des pages ayant la charte Naski : Pages d'erreurs, pannels admins...
 */

use Naski\Displayer\Bundle\Bundle;
use Assetic\Asset\FileAsset;

class NaskiPageBundle extends Bundle
{
    public function exec()
    {
        global $IM;
        $IM->twig->addCssFile(new FileAsset(ROOT_SYSTEM.'vendor/twbs/bootstrap/dist/css/bootstrap.css'));
    }
}
