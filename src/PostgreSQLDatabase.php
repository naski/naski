<?php

namespace DoePdo;

class PostgreSQLDatabase extends PdoDatabase
{

    public function getPrefixe()
    {
        return "pgsql";
    }

}
