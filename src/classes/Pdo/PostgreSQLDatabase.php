<?php

namespace Naski\Pdo;

class PostgreSQLDatabase extends PdoDatabase
{
    public function getPrefixe(): string
    {
        return 'pgsql';
    }

    protected function cleanQuotes(string $value): string
    {
        return str_replace("'", "''", $value);
    }

    public function lastInsertId(): int
    {
        $l = $this->query("SELECT lastval();")->fetch();
        return $l[0];
    }
}
