<?php

namespace Naski\Routing;

/**
 * Controlleur à hériter pour chacun des controlleurs métiers créés
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 */
abstract class Controller
{
    public $post = array(); // Tableau clé/valeur de $POST nettoyé
    public $get = array(); // Tableau clé/valeur de $GET nettoyé

    private $_inputsValids = true;
    private $_rule;
    private $_gump;

    public function __construct(Rule $rule)
    {
        $this->_rule = $rule;

        $gump = new \GUMP();
        $this->post = $gump->sanitize($_POST);
        $this->get = $gump->sanitize($_GET);

        $this->_inputsValids = ($this->testInputs('get') && $this->testInputs('post'));
    }

    private function testInputs($method)
    {
        $gump = new \GUMP();

        $gump->validation_rules(self::buildGumpRules($method, 'validation_rules'));
        $gump->filter_rules(self::buildGumpRules($method, 'filter_rules'));

        return $gump->run($this->$method);
    }

    private function buildGumpRules(string $method, string $name) :array
    {
        $rules = array();
        foreach ($rule->$method ?? array() as $param) {
            if (!($param[$name] ?? '') && $name == 'validation_rules') {
                $param[$name] = 'required';
            }
            if ($param[$name] ?? '') {
                $rules[$param['name']] = $param[$name] ?? '';
            }
        }

        return $rules;
    }

    /**
     * Test si tout les entrées POST respectent la régle
     * @return bool Vrai si toutes les régles sont respectées
     */
    public function inputValid() :bool
    {
        return $this->_inputsValids;
    }

}
