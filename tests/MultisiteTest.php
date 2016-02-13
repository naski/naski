<?php

require_once 'bootstrap.php';

use Naski\Config\Config;
use Naski\Routing\Multisite\Multisite;
use Naski\Routing\Multisite\Site;
use League\Uri\Schemes\Http as HttpUri;

class MultisiteTest extends PHPUnit_Framework_TestCase
{
    public function testDisplay()
    {
        $multisite = new Multisite(__DIR__.'/');
        $multisite->addSite($site1 = new Site(array(
            'name' => 'Site 1',
            'src' => './',
            'initFile' => 'initSite.php',
        )));
        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/'));

        $this->expectOutputString('Site 1');
    }

    public function testMatch()
    {
        $multisite = new Multisite(__DIR__.'/');
        $multisite->addSite($site2 = new Site(array(
            'name' => 'Site 2',
            'src' => './',
            'conditions' => array(
                'path' => '^/site2(.*)',
            ),
            'initFile' => 'initSite.php',
        )));
        $multisite->addSite($site1 = new Site(array(
            'name' => 'Site 1',
            'src' => './',
            'initFile' => 'initSite.php',
        )));

        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/'));
        $this->assertEquals($out, $site1);
        $this->assertNotEquals($out, $site2);

        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/site2/gogo'));
        $this->assertEquals($out, $site2);
        $this->assertNotEquals($out, $site1);
    }

    public function testLoadFile()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/product'));
        $this->assertEquals($out->name, 'Site 1');
        $this->assertNotEquals($out->name, 'Site 2');
    }

    public function testHttps()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
        $out = $multisite->process(HttpUri::createFromString('https://doelia.fr/'));
        $this->assertEquals($out->name, 'Site HTTPS');
        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/'));
        $this->assertNotEquals($out->name, 'Site HTTPS');
    }

    public function testHost()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
        $out = $multisite->process(HttpUri::createFromString('http://vps.doelia.fr/'));
        $this->assertEquals($out->name, 'Site privé');
        $out = $multisite->process(HttpUri::createFromString('http://doelia.fr/'));
        $this->assertNotEquals($out->name, 'Site privé');
    }

    /**
     * @expectedException Naski\Config\FileNotFoundException
     */
    public function testInitFileNotFound()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite_bad.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
    }

    /**
     * @expectedException Naski\Config\FileNotFoundException
     */
    public function testRoutingFileNotFound()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite_badRouting.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
    }

    public function testHandler()
    {
        $websites = new Config();
        $websites->loadFile(__DIR__.'/multisite.json');
        $multisite = MultiSite::buildFromConfig($websites, __DIR__);
        $out = $multisite->process(HttpUri::createFromString('http://vps.doelia.fr/'));
        global $sitee;
        $this->assertNotEquals($sitee, 'nop');
        $this->assertEquals($sitee, 'Site privé');
    }
}
