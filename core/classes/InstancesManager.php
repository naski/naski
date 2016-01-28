<?php

namespace Naski;

class InstancesManager
{
    public function recordInstance(string $instanceName, $instance)
    {
        $this->$instanceName = $instance;
    }

    public function getInstancesOfType(string $type)
    {
        $list = array();
        foreach ($this as $key => $value) {
            if ($key instanceof $type) {
                $list[] = $value;
            }
        }
        return $list;
    }

    public function putInstancesIn($object)
    {
        foreach ($this as $key => $value) {
            $object->$key = $value;
        }
    }
}
