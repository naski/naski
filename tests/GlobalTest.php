<?php

require_once 'boot.php';

class GlobalTesteur extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {

    }

    public function testExecs()
    {
        $out = array();
        exec('php tests/console.php cleanLogs go 2>&1', $out);
        $this->assertContains('clean_logs.sh go', $out[0]);

        $out = array();
        exec('php tests/console.php cleanCache 2>&1', $out);
        $this->assertContains('clean_cache.sh go', $out[0]);

    }

    public function testArrayKeep()
    {
        $in = array(
            'toto' => 'tata',
            'titi' => 'nono',
            'grep' => 'nana'
        );
        $in[0] = 'tutu';
        $in[1] = 'gaga';
        $in[] = 'too';

        $this->assertEquals(
            \Naski\array_keep($in, array(
                'toto', 'grep'
            )),
            array(
                'toto' => 'tata',
                'grep' => 'nana'
            )
        );
    }
}
