<?php

require_once('bootstrap.php');

use Naski\Routing\Routing;
use Naski\Routing\Rule;
use Naski\Routing\Multisite\Multisite;
use Naski\Routing\Multisite\Site;

class MultisiteTest extends PHPUnit_Framework_TestCase
{

    public function testDisplay()
    {
        $multisite = new Multisite(__DIR__ . '/');
        $multisite->addSite($site1 = new Site(array(
            'name' => 'Site 1',
            'initFile' =>  'initSite.php',
        )));
        $out = $multisite->process('doelia.fr', '/');

        $this->expectOutputString("Site 1");
    }

    public function testMatch()
    {
        $multisite = new Multisite(__DIR__ . '/');
        $multisite->addSite($site2 = new Site(array(
            'name' => 'Site 2',
            'conditions' => array(
                'path' => "^/site2(.*)"
            ),
            'initFile' =>  'initSite.php',
        )));
        $multisite->addSite($site1 = new Site(array(
            'name' => 'Site 1',
            'initFile' =>  'initSite.php',
        )));

        $out = $multisite->process('doelia.fr', '/');
        $this->assertEquals($out, $site1);
        $this->assertNotEquals($out, $site2);

        $out = $multisite->process('doelia.fr', '/site2/gogo');
        $this->assertEquals($out, $site2);
        $this->assertNotEquals($out, $site1);
    }


}
