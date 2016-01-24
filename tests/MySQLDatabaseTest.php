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

        $this->_db = new MySQLDatabase($GLOBALS['DB_MYSQL']);
        $this->_db->forceConnect();
    }

    /**
     * @expectedException DoePdo\ConnexionFailureException
     */
    public function testBadConnexion()
    {
        $db = new MySQLDatabase(array(
            'host' => '127.0.0.1',
            'dbname' => 'tests',
            'username' => 'root',
            'password' => 'baaaaad'
        ));
        $db->forceConnect();
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
