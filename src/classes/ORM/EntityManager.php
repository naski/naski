<?php

namespace Naski\ORM;

use Naski\Pdo\AbstractDatabase;

abstract class EntityManager
{

    /**
     * @return AbstractDatabase
     */
    protected abstract function getDb(): AbstractDatabase;

    /**
     * @param string $query
     * @param $type
     * @return Entity
     */
    protected function loadEntity(string $query, $type)
    {
        $entitys = $this->loadEntitys($query, $type);
        return $entitys[0] ?? null;
    }

    /**
     * @param $query
     * @param $type
     * @return array
     * @throws \Naski\Pdo\BadQueryException
     */
    protected function loadEntitys($query, $type)
    {
        $tab = array();
        $q = $this->getDb()->query($query);
        while ($l = $q->fetch()) {
            $tab[] =  new $type($l);
        }
        return $tab;
    }
}