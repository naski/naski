<?php

namespace Naski;

abstract class Controller {

    public $inputs = array(); // Tableau clé/valeur de $POST nettoyé
    public $_postValid = true;

    public function __construct(array $rule = null) {
        global $IM;
        $IM->putInstancesIn($this);

        if ($rule != null) {
            $this->setInputs($rule);
        }
    }

    private function setInputs(array $rule)
    {
        $this->gump->validation_rules(self::buildGumpRules($rule, 'validation_rules'));
        $this->gump->filter_rules(self::buildGumpRules($rule, 'filter_rules'));

        $validatedData = $this->gump->run($_POST);

        if ($validatedData === false) {
            $this->_postValid = false;
        } else {
            $this->_postValid = true;
            $this->inputs = $validatedData;
        }
    }

    public function inputValid() :bool
    {
        return $this->_postValid;
    }

    private static function buildGumpRules(array $rule, string $name) :array
    {
        $rules = array();
        foreach ($rule['params'] ?? array() as $param) {
            $rules[$param['name']] = $param[$name] ?? '';
        }
        return $rules;
    }





}
