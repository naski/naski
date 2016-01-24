<?php

use DoePdo\AbstractDatabase;

class InstancesManager {

    public $_dbInstances = array();

    public function __construct() {

    }

    public function recordInstance(string $instanceName, $instance)
    {
        $this->$instanceName = $instance;
    }

    public function recordDatabaseInstance(string $instanceName, AbstractDatabase $instance)
    {
        $this->_dbInstances[] = $instance;
        $this->recordInstance($instanceName, $instance);
    }

    public function getDatabaseInstances() :array
    {
        return $this->_dbInstances;
    }

    public function putInstancesIn($object)
    {
        foreach ($this as $key => $value) {
            $object->$key = $value;
        }
    }

}
