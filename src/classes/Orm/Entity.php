<?php

namespace Naski\ORM;

abstract class Entity
{
    public function __construct(array $datas)
    {
        $this->hydrate($datas);
    }

    protected function hydrate(array $datas)
    {
        foreach ($datas as $key => $value) {
            if (!is_numeric($key)) {
                $this->$key = $value;
            }
        }
    }
}
