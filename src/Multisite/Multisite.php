<?php

namespace Naski\Routing\Multisite;

use Naski\Config\Config;
use Naski\Routing\Routing;
use Naski\Routing\Rule;

class Multisite
{

    private $root = null; // Chemin absolu
    private $_websites = array(); // array<array>

    public static function buildFromConfig(Config $config, string $rootSystem): self
    {
        $obj = new self($rootSystem . $config['rootPath']);
        foreach ($config['websites'] as $w) {
            $obj->addSite(new Site($w));
        }
        return $obj;
    }

    public function __construct(string $root)
    {
        $this->_root = $root;
    }

    public function addSite(Site $site)
    {
        $this->_websites[] = $site;
    }

    public function process(string $domain, string $path)
    {
        foreach ($this->_websites as $w) {
            if ($w->match($domain, $path)) {
                $w->exec($this->_root);
                return $w;
            }
        }
        return null;
    }

}
