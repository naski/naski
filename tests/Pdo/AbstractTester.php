<?php

use Naski\Pdo\AbstractDatabase;

use Monolog\Logger;
use Naski\Pdo\PdoDatabase;

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

        $this->assertEquals($db->lastInsertId(), 1);

        $db->insert('tests',
            array(
                'row1' => 'gogo',
                'row2' => 'gogo',
            )
        );

        $this->assertEquals($db->lastInsertId(), 2);

        $q = $db->query("SELECT COUNT(*) FROM tests");
        $this->assertEquals($q->fetch()[0], 2);

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

    /**
     * @depends testInsert
     */
    public function testNullInsert(AbstractDatabase $db)
    {

        $db->insert('tests', array(
            'row1' => 'l1',
            'row2' => null
        ));

        $q = $db->query("SELECT * FROM tests WHERE row2 IS NULL");
        $this->assertEquals($q->rowCount(), 1);
    }

    /**
     * @depends testInsert
     */
    public function testBooleanInsert(AbstractDatabase $db)
    {

        $db->insert('tests', array(
            'row1' => 'l2',
            'row4' => true
        ));

        $q = $db->query("SELECT * FROM tests WHERE row4=TRUE");
        $this->assertEquals($q->rowCount(), 1);

        $q = $db->query("SELECT * FROM tests WHERE row4=FALSE");
        $this->assertEquals($q->rowCount(), 0);
    }

    /**
     * @depends testInsert
     */
    public function testLogRequest(AbstractDatabase $db)
    {
        $logger = new Logger('test_logs');
        $db->startLogRequest($logger);
        $db->query("SELECT * FROM tests");
        $db->stopLogRequest();
    }

    /**
     * @depends testInsert
     */
    public function testTransaction(PdoDatabase $db)
    {
        $db->getPdoInstance()->beginTransaction();
        $db->query("SELECT * FROM tests");
        $db->getPdoInstance()->commit();
    }

    /**
     * @depends testInsert
     */
    public function testOneResult(PdoDatabase $db)
    {
        $n = $db->getFirstColumn("SELECT count(*) from tests");
        $this->assertGreaterThan(0, $n);

        $n = $db->getFirstColumn("SELECT * from tests where row1='srautie'");
        $this->assertNull($n);
    }


}
