<?php

require_once 'bootstrap.php';

use Naski\Routing\Routing;
use Naski\Routing\Rule;
use Naski\Config\Config;

class RoutingTest extends PHPUnit_Framework_TestCase
{
    public function testHomePage()
    {
        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/',
            'controller' => 'TestController',
            'action' => 'testAction',
        )));

        $this->assertTrue($ROUTING->routeFind('/'));
    }

    public function testRoutingPrint()
    {
        $this->expectOutputString("\nHello\n");

        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/test',
            'controller' => 'TestController',
            'action' => 'testAction',
        )));

        $ROUTING->process('/test');
    }

    public function testRouting404()
    {
        $ROUTING = new Routing();

        $ROUTING->addRules(array(
            new Rule(array(
                'path' => '/toto',
                'controller' => 'TestController',
                'action' => 'testAction',
            )),
            new Rule(array(
                'path' => '*',
                'controller' => 'TestController',
                'action' => 'notFoundAction',
            )),
        ));

        $this->assertTrue($ROUTING->routeFind('/'));
        $this->assertTrue($ROUTING->routeFind('/baad'));
        $this->assertTrue($ROUTING->routeFind('/baad/'));
        $this->assertTrue($ROUTING->routeFind('/baad/toto'));
    }

    public function testPostRule()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_post.json');
        $routing = Routing::buildFromConfig($config);
        $_POST['username'] = 'john';
        $_POST['password'] = 'john';
        $routing->process('/login');
        $this->expectOutputString("ok");
    }

    public function testPostRuleBad()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_post.json');
        $routing = Routing::buildFromConfig($config);
        $_POST['username'] = 'john';
        $routing->process('/login');
        $this->expectOutputString("bad");
    }

    public function testRestGetUser()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_rest.json');
        $routing = Routing::buildFromConfig($config);
        $out = $routing->process('/rest/user/3');
        $this->assertTrue($out);
        $this->expectOutputString("get user 3");
    }

    public function testRestUpdateUser()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_rest.json');
        $routing = Routing::buildFromConfig($config);
        $out = $routing->process('/rest/user/3');
        $this->assertTrue($out);
        $this->expectOutputString("update user 3");
    }

    public function testJsonNeed()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_rest.json');
        $routing = Routing::buildFromConfig($config);
         $routing->process('/rest/json');
        $this->expectOutputString("NOJSON");
    }
    
}
