<?php

require_once __DIR__.'/../boot.php';

$_SERVER['REQUEST_METHOD'] = 'GET';


$sitee = "nop";
function onSite($site = 'yes') {
    global $sitee;
    $sitee = $site->name;
}

use Naski\Routing\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        echo "\nHello\n";
    }

    public function notFoundAction()
    {
        echo "\nNot Found\n";
    }

    public function loginAction()
    {
        if (!$this->inputValid()) {
            echo "bad";
        } else {
            echo "ok";
        }
    }
}

class RestController extends Controller
{
    public function getUser($id=0)
    {
        echo "get user $id";
    }

    public function updateUser($id=0)
    {
        echo "update user $id";
    }

    public function getJson()
    {
        if (!$this->inputValid()) {
            echo "NOJSON";
        } else {
            echo "OK JSON";
        }
    }
}
