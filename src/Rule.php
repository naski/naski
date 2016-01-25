<?php

namespace Naski\Routing;

class Rule
{
    public $type = 'any';
    public $path = "undefined";
    public $controller = "undefined";
    public $action = "undefined";
    public $domain = "*"; // Pour les sous-domaines, entrer foo.*
    public $httpsOnly = false;
    public $params = array(); // array<array>

    public function __construct(array $a)
    {
        foreach ($a as $key => $value) {
            $this->$key = $value;
        }
        $this->processDomain();
        if ($this->path == "*") {
            $this->path = "(/:no1(/:no2(/:no3(/:no4(/:no5)))))";
        }
        $this->verificate();
    }

    private function processDomain()
    {
        try {
            if ($this->domain != '*' && strpos($this->domain, '*') !== false) {
                $domain = $_SERVER['HTTP_HOST'];
                $suffixe = strstr($domain, '.'); // vps.doelia.fr -> .doelia.fr
                $subdomain = explode('.*', $this->domain)[0];
                $this->domain = $subdomain . $suffixe;
            }
        } catch (\Exception $e) {
            throw new BadRuleException('Champ domaine '.$this->domain." invalide : " . $e->getMessage());
        }

    }

    /**
     *  // TODO Écrire tout les tests
     */
    private function verificate()
    {
        if (!class_exists($this->controller)) {
            throw new BadRuleException('Le controlleur '.$this->controller." n'existe pas");
        }
    }
}
