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
    private $_websites = array(); // array<array>
    private $_onExecSitehandler = null;

    /**
     * Contruit une instance de Multisite à partir d'une config
     * @param  Config $config     La config à charger
     * @param  string $rootSystem Le chemin racine du projet finisant par un /, qui sera suffixé par le rootPath de la config
     * @return self             L'instance Multisite
     * // TODO vérifier la formation de la config
     */
    public static function buildFromConfig(Config $config, string $rootWebsites): self
    {
        $obj = new self();
        $obj->addSitesFromConfig($config, $rootWebsites);
        return $obj;
    }

    public function addSitesFromConfig(Config $config, string $rootWebsites) {
        foreach ($config['websites'] as $w) {
            $site = new Site($w);
            $site->src = $rootWebsites.$site->src;
            $this->addSite($site);
        }
    }

    /**
     * Définit un handler qui sera appelé quand un site sera executé
     * La variable sera appelée call_user_func($handler)
     * @param mixed $handler L'handler à appeler
     */
    public function setOnSiteHandle($handler)
    {
        $this->_onExecSitehandler = $handler;
    }

    public function addSite(Site $site)
    {
        $this->_websites[] = $site;
        $site->verificateFiles();
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
                if ($this->_onExecSitehandler != null) {
                    call_user_func($this->_onExecSitehandler, $w);
                }
                $w->exec($uri);

                return $w;
            }
        }

        return;
    }
}