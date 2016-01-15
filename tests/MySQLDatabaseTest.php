<?php

require('bootstrap.php');

use DoePdo\MySQLDatabase;

class MySQLDatabaseTest extends PHPUnit_Framework_TestCase
{
    private $_bd;

    public function testConnect()
    {
        $this->_db = new MySQLDatabase();
        $this->_db->connect(array(
            'host' => '127.0.0.1',
            'dbname' => 'test',
            'username' => 'root',
            'password' => '',
        ));
    }

    public function testCreateTable() {
        $this->_db->query("
        DROP TABLE IF EXISTS `tests`;
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
