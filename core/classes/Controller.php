<?php

namespace Naski;
use Naski\Routing\Rule;

class Controller extends \Naski\Routing\Controller {

    public function __construct(Rule $rule = null)
    {
        parent::__construct($rule);

        global $IM;
        if ($IM != null) {
            $IM->putInstancesIn($this);
        }
    }

    public function getBaseParams()
    {
        $a = array();
        $a['ROOT_URL'] = 'http://predict.dev3/';
        return $a;
    }
}
