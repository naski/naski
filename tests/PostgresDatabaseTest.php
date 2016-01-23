<?php

require('bootstrap.php');

use DoePdo\PostgreSQLDatabase;
use DoePdo\BadQueryException;

class PostgresDatabaseTest extends AbstractTester
{

    protected function setUp()
    {
        if (!isset($GLOBALS['DB_POSTGRES'])) {
            $this->markTestSkipped('Postgres désactivé.');
        }

        $this->_db = new PostgreSQLDatabase();
        $this->_db->connect($GLOBALS['DB_POSTGRES']);
    }

    /**
     * @depends testConnect
     */
    public function testCreateTable()
    {
        $this->_db->query("
        DROP TABLE IF EXISTS "public"."tests";
        CREATE TABLE "public"."tests" (
        	"ID" int4 NOT NULL,
        	"row1" varchar(255) COLLATE "default",
        	"row2" varchar(255) COLLATE "default",
        	"row3" int4
        );
        ALTER TABLE "public"."tests" ADD PRIMARY KEY ("ID") NOT DEFERRABLE INITIALLY IMMEDIATE;
        ");
    }


}
