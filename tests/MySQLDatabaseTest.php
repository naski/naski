<?php

require('bootstrap.php');

use DoePdo\MySQLDatabase;

class MySQLDatabaseTest extends PHPUnit_Framework_TestCase
{
    public function testConnect()
    {
        $db = new MySQLDatabase();
        $db->connect(array(
            'host' => '127.0.0.1',
            'dbname' => 'test',
            'username' => 'root',
            'password' => 'wugaxu',
        ));
    }
}
