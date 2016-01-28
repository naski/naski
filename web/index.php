<?php

require_once '../boot.php';

if (!IS_HTTP) {
    die('Ce site est accesible uniquement en HTTP');
}

require '../src/boot/multisite.php';
