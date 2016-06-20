<?php

use Naski\Pdo\PostgreSQLDatabase;

require_once __DIR__.'/../bootstrap.php';

class UserManager extends \Naski\ORM\EntityManager
{


    protected function getDb(): \Naski\Pdo\AbstractDatabase
    {
        return new PostgreSQLDatabase($GLOBALS['DB_POSTGRES']);
    }

    public function getUser() {
        return $this->loadEntity("SELECT * FROM tests", "User");
    }


}

class User extends \Naski\ORM\Entity
{
    public $row1;
}
