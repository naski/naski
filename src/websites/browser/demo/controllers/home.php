<?php

use Naski\Controller;
use Job\User;

class HomeController extends Controller
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
