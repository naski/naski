<?php

require_once 'bootstrap.php';

use Naski\Config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/config.json');
    }

    public function testYmlConfig()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/config.yml');

        $this->assertEquals($config['var1'], 'toto');
        $this->assertEquals($config['var404'], null);
        $this->assertEquals($config['boolean'], true);
        $this->assertEquals($config['tab'][1], 'gogo');
    }

    public function testLoop()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/config.json');
        $cpt = 0;
        foreach ($config['array1'] as $value) {
            $cpt++;
        }
        $this->assertEquals($cpt, 7);
    }


    /**
     * @expectedException Naski\Config\UnknownExtensionException
     */
    public function testNotFoundExtensionConfig()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/notfound.bobo');
    }

    /**
     * @expectedException Naski\Config\FileNotFoundException
     */
    public function testNotFoundConfig()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/notfound.json');
    }

    /**
     * @expectedException Naski\Config\BadJsonSynthaxeException
     */
    public function testBadJson()
    {
        $config = new Config();
        $config->loadFile(__DIR__.'/bad.json');
    }
}
