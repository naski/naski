<?php

$loader = new Twig_Loader_Filesystem($basepath = ROOT_SYSTEM . '/core/debug_bar');
$twig = new Twig_Environment($loader);

{

    $view = $twig->loadTemplate('view.twig');
    echo $view->render(array(
        'n_requests' => sumProperties($IM->getDatabaseInstances(), 'getRequestsNumber')
    ));
}
