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

        $this->loadBaseTwigParams();
        $this->loadDevBar();
    }

    public function addTwigParams(array $array)
    {
        $this->_twigsParams = array_merge($array, $this->_twigsParams);
    }

    public function getTwigParams()
    {
        return $this->_twigsParams;
    }

    private function loadBaseTwigParams()
    {
        global $IM;
        $this->addTwigParams(array(
            'globals' => array(
                'ROOT_URL' => 'http://predict.dev3/' // TODO
            )
        ));
        $this->addTwigParams(array(
            'IM' => $IM
        ));
    }

    private function loadDevBar()
    {
        $devBarBundle = BundleManager::getInstance()->getBundle('devBar');
        $devBarBundle->load();
        $devBarBundle->addHisTemplatesToTwig($this->twig);
        $this->addTwigParams($devBarBundle->getVariable('twig_params'));
    }
}
