<?php

require_once 'bootstrap.php';

use Naski\Config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $config = new Config();
        $config->loadJSONFile(__DIR__.'/config.json');
    }

    /**
     * @expectedException Naski\Config\FileNotFoundException
     */
    public function testNotFoundConfig()
    {
        $config = new Config();
        $config->loadJSONFile(__DIR__.'/notfound.json');
    }

    /**
     * @expectedException Naski\Config\BadJsonSynthaxeException
     */
    public function testBadJson()
    {
        $config = new Config();
        $config->loadJSONFile(__DIR__.'/bad.json');
    }
}
