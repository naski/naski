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
        global $IM;
        $template = $this->twig->loadTemplate('login.twig.html');
        echo $template->render($this->getTwigParams());
    }

    public function badAction()
    {
        echo 'Page introuvable';
    }
}
