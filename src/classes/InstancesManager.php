<?php

namespace Naski;
use Psr\Log\LoggerInterface;

/**
 * Permet de stocker et d'accéder de manière globale à des instances
 * Évite de devoir utiliser le pattern singleton pour chaque classe
 *
 * Par convention, on nomera $IM la variable globale de l'InstanceManager
 *
 * On accède à une instance avec une key directement : $IM->key
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 */
class InstancesManager
{

    // Quelques instances toujours présentes, définies pour l'autocompletion

    /**
     * @var \Naski\Config\Config
     */
    public $config;

    /**
     * @var \Naski\Displayer\NaskiDisplayer
     */
    public $dpl;

    /**
     * @var \Naski\Routing\Rule
     */
    public $rule;

    /**
     * @var LoggerInterface
     */
    public $logger;

    private $_instances = array();

    /**
     * Enregistre une nouvelle instance
     * @param  string $instanceName La clé choisie pour référencer l'instance
     * @param mixed   $instance L'instance à enregistrer
     * @return void
     */
    public function recordInstance(string $instanceName, $instance)
    {
        $this->$instanceName = $instance;
        $this->_instances[$instanceName] = $instance;
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

    public function getListInstancesKey(): array
    {
        return array_keys($this->_instances);
    }

    /**
     * Place toutes les instances enregistrées dans un objet
     * @param  mixed $object L'object dans lequel placer les instances
     * @return void
     */
    public function putInstancesIn($object)
    {
        foreach ($this->_instances as $key => $value) {
            $object->$key = $value;
        }
    }


}
