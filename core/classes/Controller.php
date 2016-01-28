<?php

namespace Naski;
use Naski\Routing\Rule;
use Naski\Bundle\BundleManager;

class Controller extends \Naski\Routing\Controller {

    private $_twigsParams = array();

    public function __construct(Rule $rule = null)
    {
        parent::__construct($rule);

        global $IM;
        $IM->recordInstance('rule', $rule);
        if ($IM != null) {
            $IM->putInstancesIn($this);
        }

        $this->loadDevBar();
    }

    public function addTwigParams(array $array)
    {
        $this->_twigsParams = array_merge($array, $this->_twigsParams);
    }

    public function loadBaseTwigParams()
    {
        $this->addTwigParams(array(
            'globals' => array(
                'ROOT_URL' => 'http://predict.dev3/' // TODO
            )
        ));
    }

    public function getTwigParams()
    {
        return $this->_twigsParams;
    }

    private function loadDevBar()
    {
        $devBarBundle = BundleManager::getInstance()->getBundle('devBar');
        $devBarBundle->load();
        $devBarBundle->addHisTemplatesToTwig($this->twig);
        $this->addTwigParams($devBarBundle->getVariable('twig_params'));
    }
}
