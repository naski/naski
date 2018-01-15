<?php


require_once 'bootstrap.php';

use Naski\Routing\Routing;
use Naski\Config\Config;
use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{

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

    public function testOptions()
    {
        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_rest.json');
        $routing = Routing::buildFromConfig($config);
        $out = $routing->process('/caca');
        $this->assertTrue($out);
        $this->expectOutputString("options");
    }

    public function test404()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $config = new Config();
        $config->loadFile(__DIR__.'/routing_rest.json');
        $routing = Routing::buildFromConfig($config);
        $out = $routing->process('/caca');
        $this->assertTrue($out);
        $this->expectOutputString("all");
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
