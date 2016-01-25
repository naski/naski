<?php

require('bootstrap.php');

use Naski\Routing\Routing;
use Naski\Routing\Rule;

class RoutingTest extends PHPUnit_Framework_TestCase
{
    public function testRouting()
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

    public function testRoutingWithDomain() {
        $_SERVER['HTTP_HOST'] = 'vps.doelia.fr';

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction',
            "domain" => 'vps.doelia.com'
        )));

        $this->assertFalse($ROUTING->routeFind('/test'));
    }

    public function testRoutingWithSubDomain() {

        $_SERVER['HTTP_HOST'] = 'vps.doelia.fr';

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            "controller" => 'TestController',
            "action" => 'testAction',
            "domain" => 'vps.*'
        )));

        $this->assertTrue($ROUTING->routeFind('/test'));
        $_SERVER['HTTP_HOST'] = 'go.doelia.fr';
        $this->assertFalse($ROUTING->routeFind('/test'));
    }

    // public function testRoutingHttps() {
    //
    //     $_SERVER['HTTP_HOST'] = 'vps.doelia.fr';
    //
    //     $ROUTING = new Routing('/test');
    //
    //     $ROUTING->addRule(new Rule(array(
    //         'path' => '/test',
    //         "controller" => 'TestController',
    //         "action" => 'testAction',
    //         "httpsOnly" => true
    //     )));
    //
    //     $this->assertFalse($ROUTING->routeFind());
    //     $_SERVER['HTTPS'] = true;
    //     $this->assertTrue($ROUTING->routeFind());
    // }
}
