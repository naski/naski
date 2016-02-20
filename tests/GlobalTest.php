<?php

require 'autoload.php';

class GlobalTesteur extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {

    }

    public function testExecs()
    {
        $this->assertContains('rm -rf', exec('php tests/console.php cleanLogs'));
    }
}
