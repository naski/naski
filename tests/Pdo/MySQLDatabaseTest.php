<?php

require 'bootstrap.php';

use Monolog\Logger;
use Naski\Pdo\MySQLDatabase;
use Naski\Pdo\AbstractDatabase;

class MySQLDatabaseTest extends AbstractTester
{
    public function testConnect() :AbstractDatabase
    {
        if (!isset($GLOBALS['DB_MYSQL'])) {
            $this->markTestSkipped('MySQL désactivé.');
        }

        $db = new MySQLDatabase($GLOBALS['DB_MYSQL']);
        $db->forceConnect();

        $db->startLogRequest(new Logger('mysql'));

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
            'password' => 'baaaaad',
        ));
        $db->forceConnect();
    }

    /**
     * @expectedException Naski\Pdo\ConnexionFailureException
     */
    public function testPostConnexion()
    {
        $data = $GLOBALS['DB_MYSQL'];
        $data['port'] = 3305; // Mauvais port, volotaire
        $db = new MySQLDatabase($data);

        $db->forceConnect();
    }

    /**
     * @depends testConnect
     */
    public function testCreateTable(AbstractDatabase $db) :AbstractDatabase
    {
        $db->query('DROP TABLE IF EXISTS tests;');
        $db->query('
        CREATE TABLE `tests` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `row1` varchar(255) DEFAULT NULL,
          `row2` varchar(255) DEFAULT NULL,
          `row3` int(11) DEFAULT NULL,
          `row4` bool,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ');

        return $db;
    }
}
