<?php

use Naski\Bundle\DisplayBundle;
use Assetic\Asset\FileAsset;

class NaskiPageBundle extends DisplayBundle
{
    public function exec()
    {
        global $IM;
        $IM->twig->addCssFile(new FileAsset(ROOT_SYSTEM.'vendor/twbs/bootstrap/dist/css/bootstrap.css'));
    }
}
