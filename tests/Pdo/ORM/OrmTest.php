<?php

require 'bootstrap.php';


class OrmTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $manager = new UserManager();
        $manager->getUser();
    }
}