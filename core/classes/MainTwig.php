<?php

namespace Naski;

use Naski\Bundle\DisplayBundle;
use Naski\Bundle\BundleManager;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\AssetCache;
use Assetic\Cache\FilesystemCache;

// TODO ne pas use 2 fois le même bundle

class MainTwig
{
    private $_twigInstance = null;
    private $_twigParams = array('bundles' => array());
    private $_css; // array<FileAsset,GlobAsset>

    public function __construct($twigOption)
    {
        $loader = new \Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
        $loader->addPath(ROOT_SYSTEM.'app/ressources/views/');

        $this->_twigInstance = new \Twig_Environment($loader, $twigOption);

        $this->loadBaseTwigParams();
        $this->useBundle('devBar');
    }

    public function getTwigInstance()
    {
        return $this->_twigInstance;
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

    // TODO Écrire des verifs
    public function useBundle(string $alias)
    {
        $bundle = BundleManager::getInstance()->getBundle($alias);
        $this->loadBundle($bundle);
    }

    public function loadBundle(DisplayBundle $bundle)
    {
        $this->_twigInstance->getLoader()->addPath($bundle->getTwigTemplatesDir(), $bundle->config->alias);
        $this->_twigParams['bundles'][$bundle->config->alias] = $bundle->getTwigParams();
        $this->_twigParams['bundles'][$bundle->config->alias]['instance'] = $bundle;
        $bundle->exec();
    }

    public function addTwigPath($path)
    {
        $this->_twigInstance->getLoader()->addPath($path);
    }

    public function addTwigParams($array)
    {
        $this->_twigParams = array_merge($array, $this->_twigParams);
    }

    public function addCssFile($file)
    {
        $this->_css[] = $file;
    }

    private function buildCss()
    {
        if (count($this->_css)) {
            $collection = new AssetCollection($this->_css);
            $cache = new AssetCache(
                $collection,
                new FilesystemCache(PATH_CACHE."assets/")
            );
            $this->addTwigParams(array('css_content' => $cache->dump()));
        }
    }

    public function render(string $templateName)
    {
        $this->buildCss();
        $template = $this->_twigInstance->loadTemplate($templateName);
        echo $template->render($this->_twigParams);
    }
}
