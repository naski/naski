<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$_SERVER['REQUEST_METHOD'] = 'GET';

if (@!include __DIR__.'/../vendor/autoload.php') {
    echo 'Install PDO Tester using `composer update`';
    exit(1);
}

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
