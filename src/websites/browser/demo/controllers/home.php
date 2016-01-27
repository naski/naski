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
        $template = $this->twig->loadTemplate('login.twig.html');
        echo $template->render($this->getBaseParams());
    }

    public function badAction()
    {
        echo 'Page introuvable';
    }
}
