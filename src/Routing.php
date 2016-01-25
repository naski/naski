<?php

namespace Naski\Routing;

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

        $called = [ $rule->controller, $rule->action ];

        $options = array();
        $options['constructor_args'] = [$rule];
        $options['secure'] = $rule->httpsOnly;
        if ($rule->domain != "*") {
            $options['domain'] = $rule->domain;
        }

        $this->_mux->$type($rule->path, $called, $options);
    }

    public function process(string $path)
    {
        $route = $this->_mux->dispatch($path);
        if ($route == null) {
            echo ("Route de '".$path."' introuvable"); // TODO gérer le 404
        } else {
            echo Executor::execute($route);
        }
    }

    public function routeFind(string $path): bool
    {
        return ($this->_mux->dispatch($path) !== null);
    }

    public function getRules(): array
    {
        return $this->_rulesArray;
    }


}
