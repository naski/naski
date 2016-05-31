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
    public $json;
    public $raw;

    private $_inputsValids = true;
    private $_rule;

    /**
     *
     * @param Rule $rule La régle exécutée en cas d'un routing. Peut être nulle
     */
    public function __construct($rule)
    {
        if ($rule != null) {
            $this->_rule = $rule;
            $this->buildInputs();
        }
    }

    private static $fackedRaw = null;

    public static function setCustomRaw(string $raw) {
        self::$fackedRaw = $raw;
    }

    private static function getRaw() {
        if (self::$fackedRaw == null) {
            return file_get_contents('php://input');
        }
        return self::$fackedRaw;
    }

    private function buildInputs()
    {
        $this->post = $_POST;
        $this->testAndFilterInputs('post');

        $this->get = $_GET;
        $this->testAndFilterInputs('get');

        $this->raw = self::getRaw();
        $this->json = json_decode($this->raw, true);
        if ($this->_rule->needJson && !$this->json) {
            $this->_inputsValids = false;
        }

    }

    /**
     * Sera appelé juste avant l'appel de l'action, prêt à l'override
     * @return void
     */
    public function init() { }

    private function testAndFilterInputs($method)
    {
        $gump = new \GUMP();

        $gump->validation_rules(self::buildGumpRules($method, 'validation_rules'));
        $gump->filter_rules(self::buildGumpRules($method, 'filter_rules'));

        $filtered = $gump->run($this->$method);

        if ($filtered === false) {
            $this->_inputsValids = false;
        } else {
            $this->$method = $filtered;
        }

    }

    private function buildGumpRules(string $method, string $name) :array
    {
        $rules = array();
        foreach ($this->_rule->$method ?? array() as $param) {
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
