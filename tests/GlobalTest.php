<?php

require_once 'boot.php';

class GlobalTesteur extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {

    }

    public function testRenameKey()
    {
        $in = array(
            'toto' => '1',
            'titi' => '2',
            'grep' => '3'
        );

        \Naski\rename_key($in, 'toto', 'n.toto');

        $this->assertEquals($in['n.toto'], '1');
        $this->assertEquals($in['titi'], '2');
        $this->assertEquals($in['toto'] ?? 'Nop.', 'Nop.');
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
