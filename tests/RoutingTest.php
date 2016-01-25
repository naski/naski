<?php

require('bootstrap.php');

use Naski\Routing\Routing;
use Naski\Routing\Rule;

class RoutingTest extends PHPUnit_Framework_TestCase
{
    public function testRouting()
    {
        $this->expectOutputString("\nHello\n");

        $ROUTING = new Routing('/test');

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction'
        )));

        $ROUTING->process();

    }

    public function testRoutingWithDomain() {
        $_SERVER['HTTP_HOST'] = 'vps.doelia.fr';

        $ROUTING = new Routing('/test');

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction',
            "domain" => 'vps.doelia.com'
        )));

        $this->assertFalse($ROUTING->routeFind());
    }

    public function testRoutingWithSubDomain() {

        $_SERVER['HTTP_HOST'] = 'vps.doelia.fr';

        $ROUTING = new Routing('/test');

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction',
            "domain" => 'vps.*'
        )));

        $this->assertTrue($ROUTING->routeFind());
        $_SERVER['HTTP_HOST'] = 'go.doelia.fr';
        $this->assertFalse($ROUTING->routeFind());
    }
}
