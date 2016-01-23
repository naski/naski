<?php

require('bootstrap.php');

use DoePdo\PostgreSQLDatabase;
use DoePdo\BadQueryException;

class PostgresDatabaseTest extends AbstractTester
{
    protected function setUp()
    {
        $this->_db = new PostgreSQLDatabase();
        $this->_db->connect($GLOBALS['DB_POSTGRES']);
    }


}
