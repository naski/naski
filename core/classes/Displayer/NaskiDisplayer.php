<?php

namespace Naski\Displayer;

use Naski\Displayer\Bundle\BundleManager;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\AssetCache;
use Assetic\Factory\AssetFactory;
use Assetic\Cache\FilesystemCache;
use Assetic\Extension\Twig\AsseticExtension;
use Assetic\AssetWriter;
use Assetic\Extension\Twig\TwigFormulaLoader;
use Assetic\Extension\Twig\TwigResource;
use Assetic\Factory\LazyAssetManager;

class NaskiDisplayer
{
    private $_twigInstance = null;
    private $_assetFactory = null;


    private $_twigParams = array('bundles' => array());
    private $_css; // array<FileAsset|GlobAsset>

    public $usedBundlesStack = array();
    public $includedCssFilesStack = array();

    public function __construct($twigOption)
    {
        $loader = new \Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
        $loader->addPath(NASKI_CORE_PATH.'ressources/');

        $this->_twigInstance = new \Twig_Environment($loader, $twigOption);

        $this->_assetFactory = new AssetFactory(ROOT_SYSTEM);
        $this->_twigInstance->addExtension(new AsseticExtension($this->_assetFactory));

        $this->loadBaseTwigParams();
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
            )
        ));
        $this->addTwigParams(array(
            'IM' => $IM
        ));
    }

    public function addTwigPath($path)
    {
        $this->_twigInstance->getLoader()->addPath($path);
    }

    /**
     * Ajoute des parametres à twig qui seront accesible de manière globale, sans alias
     * @param array $array Un tableau clé -> valeur
     */
    public function addTwigParams($array)
    {
        $this->_twigParams = array_merge($array, $this->_twigParams);
    }

    public function addCssFile($file)
    {
        $this->includedCssFilesStack[] = $file;
        $this->_css[] = $file;
    }

    private function buildCss()
    {
        global $IM;
        if (count($this->_css)) {
            $collection = new AssetCollection($this->_css);

            if ($IM->config['cache_css']) {
                $cache = new AssetCache(
                    $collection,
                    $IM->config['cache_css'] ? new FilesystemCache(NASKI_APP_PATH."cache/assets/") : null
                );
            } else {
                $cache = $collection;
            }

           // $this->addTwigParams(array('css_content' => $cache->dump()));
        }
    }

    public function render(string $templateName)
    {
       // $this->buildCss();

        $resource = new TwigResource($this->_twigInstance->getLoader(), $templateName);

        $am = new LazyAssetManager($this->_assetFactory);
        $am->setLoader('twig', new TwigFormulaLoader($this->_twigInstance));
        $am->addResource($resource, 'twig');

        $writer = new AssetWriter(ROOT_SYSTEM.'web/');
        $writer->writeManagerAssets($am);

        $template = $this->_twigInstance->loadTemplate($templateName);
        echo $template->render($this->_twigParams);
    }


    // TODO Écrire des verifs
    public function useBundle(string $alias)
    {
        if (!in_array($alias, $this->usedBundlesStack)) {
            $bundle = BundleManager::getInstance()->getBundle($alias);
            $this->_twigInstance->getLoader()->addPath($bundle->getTwigTemplatesDir(), $bundle->getAlias());
            $this->_twigParams['bundles'][$bundle->getAlias()] = $bundle->getTwigParams();
            $this->_twigParams['bundles'][$bundle->getAlias()]['instance'] = $bundle;

            $this->usedBundlesStack[] = $bundle->getAlias();
            $bundle->exec();
        }
    }


}
