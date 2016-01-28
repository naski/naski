<?php

namespace Naski;

use Naski\Routing\Rule;
use Naski\Bundle\BundleManager;
use Naski\Bundle\Bundle;
use Naski\Bundle\DisplayBundle;

class DisplayController extends Controller {

    private $_twigsParams = array();
    private $_template = null;

    public function __construct(Rule $rule = null)
    {
        parent::__construct($rule);

        $this->loadBaseTwigParams();
        $this->useBundle('devBar');
    }

    protected function loadTemplate(string $file)
    {
        $this->_template = $this->twig->loadTemplate($file);
    }

    protected function render()
    {
        return $this->_template->render($this->_twigsParams);
    }

    protected function addTwigParams(array $array)
    {
        $this->_twigsParams = array_merge($array, $this->_twigsParams);
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

    protected function useBundle(string $alias)
    {
        $bundle = BundleManager::getInstance()->getBundle($alias);
        $bundle->load();
        if ($bundle instanceof DisplayBundle) {
            $bundle->addHisTemplatesToTwig($this->twig);
            $this->addTwigParams($bundle->getTwigParams());
        }
    }

}
