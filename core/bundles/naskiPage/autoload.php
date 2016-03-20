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
<<<<<<< HEAD
        $IM->dpl->addCssFile('bootstrap.css', new FileAsset(ROOT_SYSTEM.'vendor/twbs/bootstrap/dist/css/bootstrap.css'));
        $IM->dpl->addCssFile('naski.css', new FileAsset($this->directory.'style.css'));
=======
        $IM->dpl->addCssFile(new FileAsset(ROOT_SYSTEM.'vendor/twbs/bootstrap/dist/css/bootstrap.css'));
        $IM->dpl->addCssFile(new FileAsset($this->directory.'style.css'));
>>>>>>> demo/master
    }
}
