<?php

require 'autoload.php';

class GlobalTesteur extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {

    }

    public function testExecs()
    {
        $out = array();
        exec('php tests/console.php cleanLogs go 2>&1', $out);
        $this->assertContains('app/logs', $out[1]);

        $this->assertContains('rm -rf', exec('php tests/console.php cleanCache 2>&1'));
    }
}
