<?php

namespace Naski;

class InstancesManager
{

    /**
     * Enregistre une nouvelle instance
     * @param  string $instanceName La clé choisie pour référencer d'instance
     * @param  Object $instance     L'instance à enregistrer
     * @return void
     */
    public function recordInstance(string $instanceName, $instance)
    {
        $this->$instanceName = $instance;
    }

    /**
     * Retourne l'ensemble des instances qui sont de type $type
     * @param  string $type Le type voulu
     * @return array      L'ensemble des instances
     */
    public function getInstancesOfType(string $type): array
    {
        $list = array();
        foreach ($this as $key => $value) {
            if ($key instanceof $type) {
                $list[] = $value;
            }
        }
        return $list;
    }

    /**
     * Place toutes les instances enregistrées dans un objet
     * @param  Object $object L'object dans lequel placer les instances
     * @return void
     */
    public function putInstancesIn($object)
    {
        foreach ($this as $key => $value) {
            $object->$key = $value;
        }
    }
}
