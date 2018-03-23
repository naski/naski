<?php

namespace Naski\Routing;

use FastRoute\Dispatcher;
use Naski\Config\Config;
use ReflectionClass;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;

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
    private $_rulesArray = array(); // array<Rule>

    /**
     * @var Router
     */
    private $router;

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * Instancie un routing à partir d'une Config
     * @param  Config $config La config à charger, voir des exemples pour le schéma
     * @return self         Le Routing instancié
     */
    public static function buildFromYaml(string $yaml_filename) :self
    {
        $obj = new self();
        $obj->router = new Router(
            new YamlFileLoader(ROOT_SYSTEM),
            $yaml_filename
        );
        return $obj;
    }

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
        $this->routes = new RouteCollection();

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
        $name = str_replace('/', '_', $rule->path);

        if (is_array($rule->method)) {
            $methods = $rule->method;
        } else {
            $methods = [$rule->method];
        }

        $name .= '_' . implode('_', $methods);

        $this->routes->add($name, new Route(
            $rule->path,
            [
                '_controller' => $rule->controller . '::' . $rule->action,
            ],
            [],
            [],
            '',
            [],
            $methods
        ));
    }

    /**
     * Exécute la première règle qui match avec le path donné
     * @param  string $path      Le chemin à tester
     * @param  bool $processIt Permet d'éxécuter ou non la règle
     * @return bool            Si une régle à été trouvée
     */
    public function process(string $path, $processIt = true): bool
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        $matcher = new UrlMatcher($this->routes, new RequestContext('/', $httpMethod));

        $parameters = $matcher->match($path);

        if ($parameters) {
            $action = $parameters['_controller'];

            $action = explode('::', $action);
            $controller = $action[0];
            $methodName = $action[1];

            $reflector = new ReflectionClass($controller);
            $method = $reflector->getMethod($methodName);
            $param_method = $method->getParameters();

            $vars = [];
            foreach ($param_method as $param) {
                if ($parameters[$param->name]) {
                    $vars[$param->name] = $parameters[$param->name];
                } else {
                    throw new \Exception('Parameter not found in path');
                }
            }

            if ($processIt) {
                self::processRule($controller, $methodName, $vars);
            }

            return true;
        }

        return false;
    }

    private static function processRule($controller, $action, array $vars)
    {
        /**
         * @var $ctrl \Naski\Controller
         */
        $ctrl = new $controller();
        $ctrl->init();
        call_user_func_array(array($ctrl, $action), $vars);
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
