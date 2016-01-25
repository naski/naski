<?php

use Naski\Routing\Controller;

class HomeController extends Controller
{

    public function indexAction()
    {
        $template = $this->twig->loadTemplate('demo/views/home.twig');
        echo $template->render(array(
            'demo_var' => 'Hey',
            "display" => $this->config->env
        ));
    }

    public function productAction()
    {
        if (!$this->inputValid()) {
            echo "Erreur, formulaire invalide";
        } else {
            print_r($this->inputs);
        }
    }
}
