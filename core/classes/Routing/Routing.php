<?php

namespace Naski\Routing;

use Naski\Config\Config;
use Pux\Mux;
use Pux\Executor;

class Routing
{
    private $_mux;
    private $_rulesArray = array(); // array<Rule>

    public function __construct()
    {
        $this->_mux = new Mux;
    }

    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function addRule(Rule $rule)
    {
        $this->addToMux($rule);
        $this->_rulesArray[] = $rule;
    }

    private function addToMux(Rule $rule)
    {
        $type = $rule->type ?? 'any';
        $this->_mux->$type(
            $rule->path,
            [$rule->controller, $rule->action],
            ['constructor_args' => [$rule]]
        );
    }

    public function process($path)
    {
        $route = $this->_mux->dispatch($path);
        if ($route == null) {
            die("Page '$path' introuvable");
        } else {
            echo Executor::execute($route);
        }
    }

    public function getRules(): array
    {
        return $this->_rulesArray;
    }


}
