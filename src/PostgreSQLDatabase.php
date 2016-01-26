<?php

namespace Naski\Pdo;

class PostgreSQLDatabase extends PdoDatabase
{
    public function getPrefixe(): string
    {
        return 'pgsql';
    }
}
