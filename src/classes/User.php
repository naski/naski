<?php

namespace Job;

use Naski\Entity;

class User extends Entity
{

    public static function table()
    {
        return "users";
    }

    public static function goodLogin($user, $pass)
    {
        return ($user == 'doelia' && $pass = 'wugaxu');
    }
}
