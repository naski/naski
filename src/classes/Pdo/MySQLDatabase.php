<?php

namespace Naski\Pdo;

class MySQLDatabase extends PdoDatabase
{
    public function getPrefixe(): string
    {
        return 'mysql';
    }

    protected function cleanQuotes(string $value): string
    {
        return addslashes($value);
    }
}
