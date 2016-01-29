<?php

namespace Naski\Routing\Multisite;

use Naski\Config\Config;
use Psr\Http\Message\UriInterface;

/**
 * Représente un ensemble de Site
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 *
 */
class Multisite
{
    private $_root = null; // Chemin absolu
    private $_websites = array(); // array<array>

    /**
     * Contruit une instance de Multisite à partir d'une config
     * @param  Config $config     La config à charger
     * @param  string $rootSystem Le chemin racine du projet finisant par un /, qui sera suffixé par le rootPath de la config
     * @return self             L'instance Multisite
     * // TODO vérifier la formation de la config
     */
    public static function buildFromConfig(Config $config, string $rootSystem): self
    {
        $obj = new self($rootSystem.$config['rootPath']);
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
        $site->verificateFiles($this->_root);
    }

    /**
     * Teste la liste des sites chargés dans l'ordre et execute le premier qui match
     * @param  UriInterface $uri L'URI qui sert de test
     * @return Site Une instnace du site chargé
     */
    public function process(UriInterface $uri)
    {
        foreach ($this->_websites as $w) {
            if ($w->match($uri)) {
                $w->exec($this->_root, $uri);

                return $w;
            }
        }

        return;
    }
}
