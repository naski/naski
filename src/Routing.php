<?php

namespace Naski\Routing;

use Pux\Mux;
use Pux\Executor;

class Routing
{
    private $_mux;
    private $_rulesArray = array(); // array<Rule>
    private $_404Rule = null;

    public function __construct()
    {
        $this->_mux = new Mux;
    }

    public function addRules(array $rules, string $subpath = "")
    {
        foreach ($rules as &$rule) {
            $rule->path = $subpath . $rule->path;
            $this->addRule($rule);
        }
    }

    public function addRule(Rule $rule)
    {
        if ($rule->path != '*') { // TODO choisir la synthaxe (à voir avec le multi site)
            self::addToMux($rule, $this->_mux);
            $this->_rulesArray[] = $rule;
        } else {
            $this->_404Rule = $rule;
        }
    }

    private static function addToMux(Rule $rule, Mux $mux)
    {
        $type = $rule->type ?? 'any';

        $called = [ $rule->controller, $rule->action ];

        $options = array();
        $options['constructor_args'] = [$rule];
        $options['secure'] = $rule->httpsOnly;
        if ($rule->domain != "*") {
            $options['domain'] = $rule->domain;
        }

        $mux->$type($rule->path, $called, $options);
    }

    public function process(string $path): bool
    {
        $route = $this->_mux->dispatch($path);
        if ($route === null) {
            if ($this->_404Rule !== null) {
                $classname = $this->_404Rule->controller;
                $methodeName = $this->_404Rule->action;
                $ctrl = new $classname($route);
                $ctrl->$methodeName($this->_404Rule);
            } else {
                return false;
            }
        } else {
            echo Executor::execute($route);
        }

        return true;
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
