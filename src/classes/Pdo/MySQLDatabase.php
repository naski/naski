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

    public function upsert(string $tablename, array $insertArray, array $condition)
    {
        throw new \Exception("Pas encore implémenté");
    }
}
