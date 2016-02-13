<?php

namespace Naski;

use Naski\Routing\Rule;
use Naski\Displayer\NaskiDisplayer;

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
class Controller extends \Naski\Routing\Controller {

    /**
     * @var NaskiDisplayer
     * Récupérée de InstanceManager
     */
    public $dpl;

    /**
     * @var \Naski\Routing\Rule
     * Récupérée de InstanceManager
     */
    public $rule;

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
