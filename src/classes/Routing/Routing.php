<?php

namespace Naski\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Naski\Config\Config;
use FastRoute;

/**
 * Permet de définir un ensemble de régle puis d'exécuter la bonne régle depuis un path
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 */
class Routing
{

    /**
     * @var Dispatcher
     */
    private $_dispatcher;
    private $_rulesArray = array(); // array<Rule>
    private $_defaultRule = null;

    /**
     * Instancie un routing à partir d'une Config
     * @param  Config $config La config à charger, voir des exemples pour le schéma
     * @return self         Le Routing instancié
     */
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
            throw new \Exception('Impossible de router une requête non HTTP');
        }
    }

    /**
     * Ajoute un ensemble de régles
     * @param array $rules L'ensemble des Rules à ajouter
     */
    public function addRules(array $rules)
    {
        foreach ($rules as &$rule) {
            $this->addRule($rule);
        }
    }

    /**
     * Ajoute une règle à la stack
     * @param Rule $rule La régle à ajouter
     */
    public function addRule(Rule $rule)
    {
        if ($rule->path == '*') {
            $this->_defaultRule = $rule;
        } else {
            $this->_rulesArray[] = $rule;
        }
    }

    private function createDispatcher()
    {
        global $that;
        $that = $this;

        $f = function ($that) {
            return function (RouteCollector $r) use ($that) {
                foreach ($that->getRules() as $rule) {
                    $r->addRoute($rule->method, $rule->path, $rule);
                }
            };
        };


        $this->_dispatcher = FastRoute\simpleDispatcher($f($this));
    }

    /**
     * Exécute la première règle qui match avec le path donné
     * @param  string $path      Le chemin à tester
     * @param  bool $processIt Permet d'éxécuter ou non la règle
     * @return bool            Si une régle à été trouvée
     */
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
    }

    /**
     * Execute la régle passée en parametre
     * @param  Rule   $rule La régle à exécuter
     * @param  array  $vars Tableau clé valeurs des variables détéctées
     * @return void
     */
    private static function processRule(Rule $rule, array $vars)
    {
        $controllerName = $rule->controller;

        /**
         * @var $ctrl \Naski\Controller
         */
        $ctrl = new $controllerName($rule);
        $ctrl->init();
        call_user_func_array(array($ctrl, $rule->action), $vars);
    }

    /**
     * Permet de savoir si une route existe
     * @param  string $path Le path à tester
     * @return bool       Vrai si une route est trouvée
     */
    public function routeFind(string $path): bool
    {
        return $this->process($path, false);
    }

    /**
     * Retourne d'ensemble des régles
     * @return array Le tableau des régles
     */
    public function getRules(): array
    {
        return $this->_rulesArray;
    }
}
