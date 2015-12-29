<?php

class InstancesManager {

    public function __construct() {

    }

    public function recordInstance($nameInstance, $instance) {
        $this->$nameInstance = $instance;
    }

}
