<?php

class InstancesManager {

    public function __construct() {

    }

    public function recordInstance($nameInstance, $instance) {
        $this->$nameInstance = $instance;
    }

    public function putInstancesIn($object) {
        foreach ($this as $key => $value) {
            $object->$key = $value;
        }
    }

}
