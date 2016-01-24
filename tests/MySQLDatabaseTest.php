<?php

require('bootstrap.php');

use Naski\Pdo\MySQLDatabase;
use Naski\Pdo\AbstractDatabase;
use Naski\Pdo\BadQueryException;

class MySQLDatabaseTest extends AbstractTester
{

    public function testConnect() :AbstractDatabase
    {
        if (!isset($GLOBALS['DB_MYSQL'])) {
            $this->markTestSkipped('MySQL désactivé.');
        }

        $db = new MySQLDatabase($GLOBALS['DB_MYSQL']);
        $db->forceConnect();

        return $db;
    }

    /**
     * @expectedException Naski\Pdo\ConnexionFailureException
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

    /**
     * @depends testConnect
     */
    public function testCreateTable(AbstractDatabase $db) :AbstractDatabase
    {
        $db->query("
        DROP TABLE IF EXISTS tests;
        CREATE TABLE `tests` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `row1` varchar(255) DEFAULT NULL,
          `row2` varchar(255) DEFAULT NULL,
          `row3` int(11) DEFAULT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");
        return $db;
    }


}
