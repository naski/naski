<?php

namespace Naski\Routing;

use Pux\Mux;
use Pux\Executor;

class Routing
{
    private $_mux;
    private $_rulesArray = array(); // array<Rule>
    private $_path; // URL enregistrée du client

    public function __construct(string $path)
    {
        $this->_mux = new Mux;
        $this->_path = $path;
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

    public function process()
    {
        $route = $this->_mux->dispatch($this->_path);
        if ($route == null) {
            echo ("Route de '".$this->_path."' introuvable"); // TODO gérer le 404
        } else {
            echo Executor::execute($route);
        }
    }

    public function routeFind(): bool
    {
        return ($this->_mux->dispatch($this->_path) !== null);
    }

    public function getRules(): array
    {
        return $this->_rulesArray;
    }


}
