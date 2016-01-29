<?php

/**
 *  Fichier à inclure avant chaque utilisation du framework.
 *  Ne produit aucun affichage si tout se passe bien.
 */


 // Tests de dépendance
 require_once __DIR__.'/core/boot/dependencies.php';

 // Classes des composants externes
require_once __DIR__.'/vendor/autoload.php';

// Initialisation du framework
require_once __DIR__.'/core/boot/tools.php';
require_once __DIR__.'/core/boot/paths.php';
require_once __DIR__.'/core/boot/init.php';

// Initialisation du projet
require_once __DIR__.'/src/boot/instances.php';

function exception_handler($e) {
    global $IM;
    // die('pas bien');
    try {
        throw $e;
    // } catch (\Naski\Config\FileNotFoundException $exception) {
    //     echo "Bouh";
    } catch (\Exception $exception) {

        $bundle = \Naski\Bundle\BundleManager::getInstance()->getBundle('errors');
        $bundle->load();
        $bundle->addException($exception);


        $bundle->addHisTemplatesToTwig($IM->twig);
        $template = $IM->twig->loadTemplate('@errors/view.twig');
        echo $template->render($bundle->getTwigParams());

        // var_dump($exception);
    }

}
