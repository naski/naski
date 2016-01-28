<?php

namespace Naski\Bundle;

/**
 * Bundle qui est capable de s'intégrer dans une page web
 * Contient des templates twig, des variable
 * // TODO et bientôt des assets...
 */
abstract class DisplayBundle extends Bundle
{

    /**
     * A overide dans votre bundle pour ajouter des parametres twig
     * @return [type] [description]
     */
    protected function getTwigParamsOveride(): array
    {
        return array();
    }

    public function getTwigParams(): array
    {
        $a = array(
            'bundle' => $this
        );
        return array_merge($a, $this->getTwigParamsOveride());
    }

    public function addHisTemplatesToTwig($twig)
    {
        $pathTwig = $this->directory.$this->config->twig_path;
        $twig->getLoader()->addPath($pathTwig, $this->config->alias);
    }

}
