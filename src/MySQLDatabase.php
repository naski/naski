<?php

namespace DoePdo;

class MySQLDatabase extends PdoDatabase
{
    
    public function getPrefixe()
    {
        return "mysql";
    }

}
