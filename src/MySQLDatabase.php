<?php

namespace Naski\Pdo;

class MySQLDatabase extends PdoDatabase
{
    public function getPrefixe(): string
    {
        return 'mysql';
    }
}
