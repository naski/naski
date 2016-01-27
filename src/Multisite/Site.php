<?php

namespace Naski\Routing\Multisite;

use Naski\Config\Config;
use Naski\Routing\Routing;
use Psr\Http\Message\UriInterface;

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

    /**
     *  // TODO Écrire tout les tests
     *  Tester l'existance des fichiers donnés.
     */
    private function verificate()
    {
        foreach ($this as $key => $value) {
            if ($value === null) {
                throw new \Exception("La propriété $key n'est pas référencée.");
            }
        }
    }

    public function exec($rootDir, UriInterface $uri)
    {
        $SITE = $this; // Utilisable dans le fichier inclus
        $PATH = $this->getNewPath($uri->getPath());
        require $rootDir.$this->src.$this->initFile;

        if ($this->routingFile ?? '') {
            $routingFile = $rootDir.$this->src.$this->routingFile;

            $config = new Config();
            $config->loadJSONFile($routingFile);

            $routing = Routing::buildFromConfig($config);

            if (!$routing->process($PATH)) {
                throw new \Exception("Aucune route n'a été trouvée");
            }
        }
    }

    public function getNewPath($path): string
    {
        if ($this->conditions['path'] ?? '') {
            $regex = '#'.$this->conditions['path'].'#';
            $result = preg_replace($regex, '${1}', $path);

            return $result;
        }

        return $path;
    }

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
