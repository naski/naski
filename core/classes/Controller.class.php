<?php

namespace Naski;

abstract class Controller {

    public function __construct() {
        global $IM;
        $IM->putInstancesIn($this);
    }
}
