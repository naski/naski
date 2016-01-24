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

        $this->_db = new PostgreSQLDatabase($GLOBALS['DB_POSTGRES']);
        $this->_db->forceConnect();
    }

    public function testCreateTable()
    {
        $this->_db->query('DROP TABLE IF EXISTS "public"."tests";');
        $this->_db->query('CREATE TABLE "public"."tests" (
            	"ID" SERIAL PRIMARY KEY,
            	"row1" varchar(255) COLLATE "default",
            	"row2" varchar(255) COLLATE "default",
            	"row3" int4
            );');
    }


}
