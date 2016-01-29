<?php

use Naski\DisplayController;
use Job\User;

class HomeController extends DisplayController
{
    public function indexAction()
    {
        $this->displayLoginForm();
    }

    private function displayLoginForm()
    {
        $this->twig->addTwigParams(array(
            'var_demo' => "It's work!"
        ));
        $this->twig->render('login.twig.html');
    }

    public function badAction()
    {
        echo 'Page introuvable';
    }
}
