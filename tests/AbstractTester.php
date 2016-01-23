<?php

use DoePdo\BadQueryException;

abstract class AbstractTester extends PHPUnit_Framework_TestCase
{
    protected $_bd;

    public function testConnect()
    {
        $this->assertTrue(true);
    }

    /**
     * @depends testConnect
     */
    abstract public function testCreateTable();

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
     * @expectedException DoePdo\ConnexionFailureException
     */
    public function testBadConnexion() {
        $datas = array(
            'host' => '127.0.0.1',
            'dbname' => 'tests',
            'username' => 'root',
            'password' => 'baaaaad'
        );
        $this->_db->connect($datas);
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
