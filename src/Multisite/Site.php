<?php

namespace Naski\Routing\Multisite;

use Naski\Config\Config;
use Naski\Config\FileNotFoundException;
use Naski\Routing\Routing;
use Psr\Http\Message\UriInterface;

/**
 * Représente un site web avec ses conditions d'accès à respecter et ses instructions à exécuter
 * Un site web peut être aussi bien une page web qu'une webservice
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 *
 */
class Site
{
    public $name = null;
    public $src = null; // Chemin relatif, finisant par /
    public $initFile = null; // Chemin relatif à $src
    public $routingFile = ''; // Chemin relatif à $src
    public $conditions = array();

    public function __construct(array $a)
    {
        foreach ($a as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            } else {
                throw new \Exception("La propriété $key n'est pas reconnue pour définir un site");
            }
        }

        $this->verificate();
    }

    private function verificate()
    {
        foreach ($this as $key => $value) {
            if ($value === null) {
                throw new \Exception("La propriété $key n'est pas référencée.");
            }
        }
    }

    public function verificateFiles(string $rootDir)
    {
        $filename = $rootDir.$this->src.$this->initFile;
        if (!file_exists($filename)) {
            throw new FileNotFoundException('Le fichier d\'initialisation '.$filename.' n\'existe pas');
        }

        if ($this->routingFile ?? '') {
            $filename = $rootDir.$this->src.$this->routingFile;
            if (!file_exists($filename)) {
                throw new FileNotFoundException('Le fichier de routing '.$filename.' n\'existe pas');
            }
        }
    }

    /**
     * Execute le site et déclanche son initilasiation
     * @param  string       $rootDir Le chemin absolue de l'emplacement des sites
     * @param  UriInterface $uri     l'URI du client
     * @return void
     */
    public function exec(string $rootDir, UriInterface $uri)
    {
        $SITE = $this; // Utilisable dans le fichier inclus
        $PATH = $this->getNewPath($uri->getPath());
        require $rootDir.$this->src.$this->initFile;

        if ($this->routingFile ?? '') {
            $routingFile = $rootDir.$this->src.$this->routingFile;

            $config = new Config();
            $config->loadFile($routingFile);

            $routing = Routing::buildFromConfig($config);

            if (!$routing->process($PATH)) {
                throw new \Exception("Aucune route n'a été trouvée");
            }
        }
    }

    /**
     * Retourne le nouveau chemin calculé à partir de la regex PATH
     * @param  string $path L'ancien chemin
     * @return string       Le nouveau chemin
     */
    public function getNewPath(string $path): string
    {
        if ($this->conditions['path'] ?? '') {
            $regex = '#'.$this->conditions['path'].'#';
            $result = preg_replace($regex, '${1}', $path);

            return $result;
        }

        return $path;
    }

    /**
     * Teste si le site respecte toutes les conditions d'une URI
     * @param  UriInterface $uri L'URI cliente à tester
     * @return bool            Vrai si ce site match
     */
    public function match(UriInterface $uri): bool
    {
        $path = $uri->getPath();
        if ($this->conditions['path'] ?? '') {
            if ($this->getNewPath($path) == $path) {
                return false;
            }
        }
        if ($this->conditions['host'] ?? '') {
            $regex = '#'.$this->conditions['host'].'#';
            if (!preg_match($regex, $uri->getHost())) {
                return false;
            }
        }
        if ($this->conditions['https'] ?? false) {
            if ($uri->getScheme() != 'https') {
                return false;
            }
        }

        return true;
    }
}
