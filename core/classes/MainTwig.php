<?php

namespace Naski;

use Naski\Bundle\DisplayBundle;


class MainTwig
{
    private $_twigInstance = null;
    private $_twigParams = array('bundles' => array());

    public function __construct($twigOption)
    {
        $loader = new \Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
        $loader->addPath(ROOT_SYSTEM.'app/ressources/views/');

        $this->_twigInstance = new \Twig_Environment($loader, $twigOption);

        $this->loadBaseTwigParams();

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

    public function loadBundle(DisplayBundle $bundle)
    {
        $this->_twigInstance->getLoader()->addPath($bundle->getTwigTemplatesDir(), $bundle->config->alias);
        $this->_twigParams['bundles'][$bundle->config->alias] = $bundle->getTwigParams();
        $this->_twigParams['bundles'][$bundle->config->alias]['instance'] = $bundle;
    }

    public function addTwigPath($path)
    {
        $this->_twigInstance->getLoader()->addPath($path);
    }

    public function addTwigParams($array)
    {
        $this->_twigParams = array_merge($array, $this->_twigParams);
    }

    public function getTwigInstance()
    {
        return $this->_twigInstance;
    }

    public function render(string $templateName)
    {
        $template = $this->_twigInstance->loadTemplate($templateName);
        echo $template->render($this->_twigParams);
    }
}
