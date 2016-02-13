<?php

namespace Naski;

use Naski\Routing\Rule;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
class Controller extends \Naski\Routing\Controller {

    public function __construct(Rule $rule = null)
    {
        parent::__construct($rule);

        global $IM;
        $IM->recordInstance('rule', $rule);
        if ($IM != null) {
            $IM->putInstancesIn($this);
        }
    }

}
