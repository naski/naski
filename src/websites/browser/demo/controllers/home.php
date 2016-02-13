<?php

use Naski\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $this->displayLoginForm();
    }

    private function displayLoginForm()
    {
        $this->dpl->addTwigParams(array(
            'var_demo' => "It's work!"
        ));
        $this->dpl->render('login.twig.html');
    }

    public function badAction()
    {
        $this->dpl->useBundle('naskiPage');
        $this->dpl->render('404.twig');
    }
}
