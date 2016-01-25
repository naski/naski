<?php

require('bootstrap.php');

use Naski\Routing\Routing;
use Naski\Routing\Rule;

class RoutingTest extends PHPUnit_Framework_TestCase
{
    public function testRouting()
    {
        // $mainRules = new Config();
        // $mainRules->loadJSONFile(ROOT_SYSTEM . 'src/demo/routing.json');
        // $rules = Rule::createRulesFromConfig($mainRules);

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction'
        )));

        $ROUTING->process('/test');

    }
}
