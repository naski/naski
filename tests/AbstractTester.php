<?php

use Naski\Pdo\AbstractDatabase;

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
        $db->insert('tests',
            array(
                'row1' => 'v11',
                'row2' => 'v12',
            )
        );

        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testSelect(AbstractDatabase $db) :AbstractDatabase
    {
        $q = $db->query('SELECT * FROM tests');
        $l = $q->fetch();
        $this->assertEquals($l['row1'], 'v11');

        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testUpdate(AbstractDatabase $db) :AbstractDatabase
    {
        $db->insert('tests',
            array(
                'row1' => 'toto',
                'row2' => 'tata',
            )
        );

        $db->update('tests',
            array(
                'row2' => 'new',
            ),
            array('row1' => 'v11')
        );

        $q = $db->query("SELECT * FROM tests WHERE row1='v11'");
        $l = $q->fetch();
        $this->assertEquals($l['row2'], 'new');

        $q = $db->query("SELECT * FROM tests WHERE row1='toto'");
        $l = $q->fetch();
        $this->assertEquals($l['row2'], 'tata');

        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testQuoted(AbstractDatabase $db) :AbstractDatabase
    {
        $message = "c'est une histoire";
        $db->insert('tests',
            array(
                'row1' => 'v3',
                'row2' => $message,
            )
        );
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
