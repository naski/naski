<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

$_SERVER['REQUEST_METHOD'] = 'GET';

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install PDO Tester using `composer update`';
	exit(1);
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
}
