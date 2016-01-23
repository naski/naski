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

    public function testCreateTable()
    {
        $this->_db->query("
        DROP TABLE IF EXISTS tests;
        CREATE TABLE `tests` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `row1` varchar(255) DEFAULT NULL,
          `row2` varchar(255) DEFAULT NULL,
          `row3` int(11) DEFAULT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");
    }


}
