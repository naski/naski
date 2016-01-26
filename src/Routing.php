<?php

namespace Naski\Routing;

use Naski\Config\Config;
use FastRoute;

class Routing
{
    private $_dispatcher;
    private $_rulesArray = array(); // array<Rule>
    private $_defaultRule = null;

    public static function buildFromConfig(Config $config) :self
    {
        $obj = new self();
        foreach ($config['rules'] as $r) {
            $obj->addRule(new Rule($r));
        }
        return $obj;
    }

    public function __construct()
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new \Exception("Impossible de router une requête non HTTP");
        }
    }

    public function addRules(array $rules)
    {
        foreach ($rules as &$rule) {
            $this->addRule($rule);
        }
    }

    public function addRule(Rule $rule)
    {
        if ($rule->path == '*') {
            $this->_defaultRule = $rule;
        } else {
            $this->_rulesArray[] = $rule;
        }
    }

    private function createDispatcher() {
        global $that;
        $that = $this;
        $this->_dispatcher = \FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            global $that;
            foreach ($that->getRules() as $rule) {
                $r->addRoute($rule->type, $rule->path, $rule);
            }
        });
    }

    public function process(string $path, $processIt = true): bool
    {
        $this->createDispatcher();
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $routeInfo = $this->_dispatcher->dispatch($httpMethod, $path);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                if ($processIt) {
                    self::processRule($handler, $vars);
                }
                return true;
                break;
            default:
                if ($this->_defaultRule != null) {
                    self::processRule($this->_defaultRule, array());
                    return true;
                }
                return false;
                break;
        }
        return false;
    }

    private static function processRule(Rule $rule, array $vars) {
        $controllerName = $rule->controller;
        $ctrl = new $controllerName($rule);
        call_user_func_array(array($ctrl, $rule->action), $vars);
    }

    public function routeFind(string $path): bool
    {
        return $this->process($path, false);
    }

    public function getRules(): array
    {
        return $this->_rulesArray;
    }


}
