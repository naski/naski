<?php

require 'bootstrap.php';

use Monolog\Logger;
use Naski\Pdo\PostgreSQLDatabase;
use Naski\Pdo\AbstractDatabase;

class PostgresDatabaseTest extends AbstractTester
{
    public function testConnect() :AbstractDatabase
    {
        if (!isset($GLOBALS['DB_POSTGRES'])) {
            $this->markTestSkipped('Postgres désactivé.');
        }

        $db = new PostgreSQLDatabase($GLOBALS['DB_POSTGRES']);
        $db->forceConnect();

        $db->startLogRequest(new Logger('postgres'));

        return $db;
    }

    /**
     * @depends testConnect
     */
    public function testCreateTable(AbstractDatabase $db) :AbstractDatabase
    {
        $db->query('DROP TABLE IF EXISTS "public"."tests";');
        $db->query('CREATE TABLE "public"."tests" (
            	"ID" SERIAL PRIMARY KEY,
            	"row1" varchar(255) COLLATE "default",
            	"row2" varchar(255) COLLATE "default",
            	"row3" int4,
                "row4" bool
            );');

        return $db;
    }

    /**
     * @depends testInsert
     */
    public function testUpsert(AbstractDatabase $db) :AbstractDatabase
    {
        $db->upsert('tests',
            array(
                'row2' => 'new_upsert',
            ),
            array('row1' => 'v11')
        );

        return $db;
    }

    /**
     * @depends testConnect
     */
    public function testImportFile(AbstractDatabase $db) :AbstractDatabase
    {
        echo "testImportFile\n";
        $db->execFile(ROOT_SYSTEM.'config/testImport.sql');

        $n = $db->getFirstColumn("SELECT count(*) from imported_file");
        $this->assertGreaterThan(0, $n);

        return $db;
    }
}
