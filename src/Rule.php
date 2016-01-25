<?php

namespace Naski\Routing;

class Rule
{
    public $type = 'any';
    public $path = "undefined";
    public $controller = "undefined";
    public $action = "undefined";
    public $params = array(); // array<array>

    public function __construct(array $a)
    {
        foreach ($a as $key => $value) {
            $this->$key = $value;
        }
        $this->verificate();
    }

    /**
     *  // TODO Écrire tout les tests
     */
    private function verificate()
    {
        if (!class_exists($this->controller)) {
            throw new BadRuleException('Le controlleur '.$this->controller." n'existe pas");
        }
    }
}
