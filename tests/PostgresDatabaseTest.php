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
            	"row3" int4
            );');

        return $db;
    }
}
