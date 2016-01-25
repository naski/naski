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

    public function testRouting404() {

        $this->expectOutputString("\nNot Found\n");

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '*',
            "controller" => 'TestController',
            "action" => 'notFoundAction',
        )));

        $ROUTING->process('/baaad');
    }

    public function testRoutingSubSite() {

        $ROUTING = new Routing();

        $ROUTING->addRules(
            array(
                new Rule(array(
                    'path' => '*',
                    "controller" => 'TestController',
                    "action" => 'notFoundAction',
                ))
            ),
            $subpath = '/site1'
        );

        $this->assertTrue($ROUTING->routeFind('/site1/gogo'));
        $this->assertTrue($ROUTING->routeFind('/site1/gogo/gaga'));
        $this->assertTrue($ROUTING->routeFind('/site1/gogo/gaga/bobo.xml'));
        $this->assertTrue($ROUTING->routeFind('/site1'));
        $this->assertFalse($ROUTING->routeFind('/site2'));
        $this->assertFalse($ROUTING->routeFind('/site2/toto'));
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
