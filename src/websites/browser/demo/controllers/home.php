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
        $this->loadTemplate('login.twig.html');
        $this->addTwigParams(array(
            'var_demo' => "It's work!"
        ));
        echo $this->render();
    }

    public function badAction()
    {
        echo 'Page introuvable';
    }
}
