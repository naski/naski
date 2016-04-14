<?php

namespace Naski\Routing\Tester;

use Naski\Routing\Controller;
use Naski\Routing\Routing;
use FastRoute\Dispatcher;
use FastRoute;

class RoutingTester
{

    private $routing;

    public function __construct(Routing $r)
    {
        $this->routing = $r;
    }

    private function simulateRequest($path, $method) {
        $_SERVER['REQUEST_METHOD'] = $method;

        ob_start();
        $this->routing->process($path, true);
        $content = ob_get_contents();
        ob_end_flush();
        return $content;
    }

    public function get(string $path, array $params = array()): string {
        $_GET = $params;
        return $this->simulateRequest($path, 'GET');
    }

    public function post(string $path, array $params = array()) {
        $_POST = $params;
        return $this->simulateRequest($path, 'POST');
    }

    public function put(string $path, array $params = array()) {
        $_POST = $params;
        return $this->simulateRequest($path, 'PUT');
    }

    public function postJson(string $path, array $json = array()) {
        Controller::setCustomRaw(json_encode($json));
        return $this->simulateRequest($path, 'POST');
    }

    public function putJson(string $path, array $json = array()) {
        Controller::setCustomRaw(json_encode($json));
        return $this->simulateRequest($path, 'PUT');
    }


}
