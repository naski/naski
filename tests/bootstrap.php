<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install PDO Tester using `composer update`';
	exit(1);
}

require_once __DIR__ . '/AbstractTester.php';
