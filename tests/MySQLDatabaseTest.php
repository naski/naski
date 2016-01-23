<?php

require('bootstrap.php');

use DoePdo\MySQLDatabase;
use DoePdo\BadQueryException;

class MySQLDatabaseTest extends AbstractTester
{

    protected function setUp()
    {
        if (!isset($GLOBALS['DB_MYSQL'])) {
            $this->markTestSkipped('MySQL désactivé.');
        }

        $this->_db = new MySQLDatabase();
        $this->_db->connect($GLOBALS['DB_MYSQL']);
    }


}
