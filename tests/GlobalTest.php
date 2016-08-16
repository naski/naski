<?php

require_once 'boot.php';

class GlobalTesteur extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {

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
