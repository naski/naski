<?php

require('bootstrap.php');

use DoePdo\MySQLDatabase;
use DoePdo\BadQueryException;

class MySQLDatabaseTest extends PHPUnit_Framework_TestCase
{
    private $_bd;

    protected function setUp()
    {
        $this->_db = new MySQLDatabase();
        $this->_db->connect($GLOBALS['DB_MYSQL']);
    }

    public function testConnect()
    {

    }

    /**
     * @depends testConnect
     */
    public function testCreateTable()
    {
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

    /**
     * @depends testCreateTable
     */
    public function testInsert()
    {
        $this->_db->insert("tests",
            array(
                "row1" => "v11",
                "row2" => "v12"
            )
        );
    }

    /**
     * @depends testInsert
     */
    public function testSelect()
    {
        $q = $this->_db->query("SELECT * FROM tests");
        $l = $q->fetch();
        $this->assertEquals($l['row1'], 'v11');
    }

    /**
     * @depends testInsert
     */
    public function testUpdate()
    {
        $this->_db->update("tests",
            array(
                "row1" => "v11.1",
                "row2" => "v12.1"
            ),
            "WHERE row1='v11'"
        );
        $q = $this->_db->query("SELECT * FROM tests");
        $l = $q->fetch();
        $this->assertEquals($l['row1'], 'v11.1');
    }

}
