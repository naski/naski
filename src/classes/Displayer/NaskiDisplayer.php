<?php

namespace Naski\Displayer;

use Assetic\AssetManager;
use Naski\Displayer\Bundle\BundleManager;

use Assetic\Asset\AssetCollection;
use Assetic\AssetWriter;


class NaskiDisplayer
{
    private $_twigInstance = null;

    private $_twigParams = array('bundles' => array());
    private $_css; // array<FileAsset|GlobAsset>
    private $_js; // array<FileAsset|GlobAsset>

    public $usedBundlesStack = array();
    public $includedCssFilesStack = array();

    public function __construct($twigOption)
    {
        $loader = new \Twig_Loader_Filesystem($basepath = ROOT_SYSTEM);
        $loader->addPath(NASKI_CORE_PATH.'ressources/');

        $this->_twigInstance = new \Twig_Environment($loader, $twigOption);

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

    public function addCssFile($output, $input)
    {
        $this->includedCssFilesStack[] = $input;
        $this->_css[$output][] = $input;
    }

    public function addJsFile($output, $input)
    {
        $this->_js[$output][] = $input;
    }

    private function buildCss()
    {
        $twig_files = array(); // Liens affichés dans l'HTML

        if (count($this->_css)) {
            foreach ($this->_css as $output => $input) {

                $collection = new AssetCollection($input);
                $collection->setTargetPath($output);

                $am = new AssetManager();
                $am->set('css', $collection);

                $writer = new AssetWriter(ROOT_SYSTEM.'web/generated_assets/css/');
                $writer->writeManagerAssets($am);

                $twig_files[] = '/generated_assets/css/'.$output;
            }
        }

        $this->addTwigParams(array('css_files' => $twig_files));
    }

    private function buildJs()
    {
        $twig_files = array(); // Liens affichés dans l'HTML

        if (count($this->_js)) {
            foreach ($this->_js as $output => $input) {

                $collection = new AssetCollection($input);
                $collection->setTargetPath($output);

                $am = new AssetManager();
                $am->set('js', $collection);

                $writer = new AssetWriter(ROOT_SYSTEM.'web/generated_assets/js/');
                $writer->writeManagerAssets($am);

                $twig_files[] = '/generated_assets/js/'.$output;
            }
        }

        $this->addTwigParams(array('js_files' => $twig_files));
    }

    public function render(string $templateName)
    {
        $this->buildCss();
        $this->buildJs();

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
