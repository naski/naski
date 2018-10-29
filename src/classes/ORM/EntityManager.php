<?php

namespace Naski\ORM;

use Naski\Pdo\PdoDatabase;

abstract class EntityManager
{

    /**
     * @return PdoDatabase
     */
    protected abstract function getDb(): PdoDatabase;

    /**
     * @param string $query
     * @param $type
     * @return Entity
     */
    public function loadEntity(string $query, $type, $args = [])
    {
        $entitys = $this->loadEntitys($query, $type, $args);
        return $entitys[0] ?? null;
    }

    /**
     * @param $query
     * @param $type
     * @return array
     * @throws \Naski\Pdo\BadQueryException
     */
    public function loadEntitys($query, $type, $args = [])
    {
        $tab = array();
        $q = $this->getDb()->getPdoInstance()->prepare($query);
        $q->execute($args);
        while ($l = $q->fetch()) {
            $tab[] =  new $type($l);
        }
        return $tab;
    }
}
