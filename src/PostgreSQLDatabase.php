<?php

namespace DoePdo;

class PostgreSQLDatabase extends PdoDatabase
{

    public function getPrefixe(): string
    {
        return "pgsql";
    }

}
