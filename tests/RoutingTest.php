<?php

require_once('bootstrap.php');

use Naski\Routing\Routing;
use Naski\Routing\Rule;

class RoutingTest extends PHPUnit_Framework_TestCase
{

    public function testHomePage()
    {
        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/',
            "controller" => 'TestController',
            "action" => 'testAction'
        )));

        $this->assertTrue($ROUTING->routeFind('/'));
    }

    public function testRoutingPrint()
    {
        $this->expectOutputString("\nHello\n");

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction'
        )));

        $ROUTING->process('/test');

    }

    public function testRouting404() {

        $ROUTING = new Routing();

        $ROUTING->addRules(array(
            new Rule(array(
                'path' => '/toto',
                "controller" => 'TestController',
                "action" => 'testAction',
            )),
            new Rule(array(
                'path' => '*',
                "controller" => 'TestController',
                "action" => 'notFoundAction',
            )),
        ));

        $this->assertTrue($ROUTING->routeFind('/'));
        $this->assertTrue($ROUTING->routeFind('/baad'));
        $this->assertTrue($ROUTING->routeFind('/baad/'));
        $this->assertTrue($ROUTING->routeFind('/baad/toto'));
    }


}
