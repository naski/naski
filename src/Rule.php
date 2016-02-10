<?php

namespace Naski\Routing;

/**
 * Représente une régle pour un routing, possédant ses conditions et son action à déclancher
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 */
class Rule
{
    public $type = ['GET', 'POST'];
    public $path = 'undefined';
    public $controller = 'undefined';
    public $action = 'undefined';
    public $post = array(); // array<array>
    public $get = array(); // array<array>

    public function __construct(array $a)
    {
        foreach ($a as $key => $value) {
            $this->$key = $value;
        }

        $this->verificate();
    }

    /**
     *  // TODO Écrire tout les tests.
     */
    private function verificate()
    {
        if (!class_exists($this->controller)) {
            throw new BadRuleException('Le controlleur '.$this->controller." n'existe pas");
        }
    }
}
