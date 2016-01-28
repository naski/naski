<?php

namespace Naski;

use Naski\Routing\Rule;
use Naski\Bundle\BundleManager;
use Naski\Bundle\Bundle;
use Naski\Bundle\DisplayBundle;

/**
 * Représente un controlleur qui réalise un affichage sur une page
 *
 * Faire hériter de ce controlleur permet d'accéder à des bundles,
 * d'accéder aux variables globales dans les templates, etc
 *
 * Pour faire un rendu, utiliser obligatoirement les méthodes de cette classe :
 * loadTemplate(), addTwigParams() et render()
 * Ne pas accéder à Twig directement
 *
 * @author Stéphane Wouters <doelia@doelia.fr>
 *
 */
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

    /**
     * Permet de charger un bundle dans le rendu de Twig
     * Le bundle doit être chargé dans la mémoire
     *
     * @param  string $alias L'alias du bundle
     */
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
