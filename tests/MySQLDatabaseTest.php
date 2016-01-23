<?php

require('bootstrap.php');

use DoePdo\MySQLDatabase;
use DoePdo\BadQueryException;

class MySQLDatabaseTest extends AbstractTester
{
    protected $_bd;

    protected function setUp()
    {
        $this->_db = new MySQLDatabase();
        $this->_db->connect($GLOBALS['DB_MYSQL']);
    }

    

}
