<?php

require_once 'bootstrap.php';

use Naski\Routing\Routing;
use Naski\Routing\Rule;
use Naski\Config\Config;

class TesterTest extends PHPUnit_Framework_TestCase
{
    public function testHomePage()
    {
        $ROUTING = new Routing();

        $ROUTING->addRule(new Rule(array(
            'path' => '/',
            'controller' => 'TestController',
            'action' => 'testAction',
        )));

        $routingTest = new \Naski\Routing\Tester\RoutingTester($ROUTING);
        $content = $routingTest->get('/');
        echo $content;

    }



}
