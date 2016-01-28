<?php

namespace Naski\Routing;

abstract class Controller
{
    public $inputs = array(); // Tableau clé/valeur de $POST nettoyé
    private $_postValid = true;

    public function __construct(Rule $rule = null)
    {
        if ($rule != null) {
            $this->setInputs($rule);
        }
    }

    private function setInputs(Rule $rule)
    {
        $gump = new \GUMP();

        $_POST = $gump->sanitize($_POST);

        $gump->validation_rules(self::buildGumpRules($rule, 'validation_rules'));
        $gump->filter_rules(self::buildGumpRules($rule, 'filter_rules'));

        $validatedData = $gump->run($_POST);

        if ($validatedData === false) {
            $this->_postValid = false;
        } else {
            $this->_postValid = true;
            $this->inputs = $validatedData;
        }
    }

    /**
     * Test si tout les entrées POST respectent la régle
     * @return bool Vrai si toutes les régles sont respectées
     */
    public function inputValid() :bool
    {
        return $this->_postValid;
    }

    private static function buildGumpRules(Rule $rule, string $name) :array
    {
        $rules = array();
        foreach ($rule->params ?? array() as $param) {
            if (!($param[$name] ?? '') && $name == 'validation_rules') {
                $param[$name] = 'required';
            }
            if ($param[$name] ?? '') {
                $rules[$param['name']] = $param[$name] ?? '';
            }
        }

        return $rules;
    }
}
