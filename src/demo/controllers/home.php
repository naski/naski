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

    public function home()
    {
        echo "Home page";
    }

    public function productAction()
    {
        if (!$this->inputValid()) {
            echo "Erreur, formulaire invalide";
        } else {
            print_r($this->inputs);
        }
    }

    public function badAction()
    {
        echo "Page introuvable";
    }
}
