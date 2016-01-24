<?php

use DoePdo\BadQueryException;
use DoePdo\AbstractDatabase;


abstract class AbstractTester extends PHPUnit_Framework_TestCase
{
    protected $_bd;

    abstract public function testConnect() :AbstractDatabase;

    /**
     * @depends testConnect
     */
    abstract public function testCreateTable(AbstractDatabase $db) :AbstractDatabase;

    /**
     * @depends testCreateTable
     */
    public function testInsert(AbstractDatabase $db) :AbstractDatabase
    {
        $db->insert("tests",
            array(
                "row1" => "v11",
                "row2" => "v12"
            )
        );
        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testSelect(AbstractDatabase $db) :AbstractDatabase
    {
        $q = $db->query("SELECT * FROM tests");
        $l = $q->fetch();
        $this->assertEquals($l['row1'], 'v11');
        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testUpdate(AbstractDatabase $db) :AbstractDatabase
    {
        $db->update("tests",
            array(
                "row1" => "v11.1",
                "row2" => "v12.1"
            ),
            "WHERE row1='v11'"
        );
        $q = $db->query("SELECT * FROM tests");
        $l = $q->fetch();
        $this->assertEquals($l['row1'], 'v11.1');
        return $db;
    }

    /**
     * @depends testUpdate
     */
    public function testCounter(AbstractDatabase $db)
    {
        $this->assertGreaterThan(0, $db->getRequestsNumber());
    }

}
