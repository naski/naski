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

    public function loginAction() {
        if ($this->inputValid()) {
            $this->dpl->addTwigParams(array("text" => "login sur ".$this->post['username']));
            $this->dpl->render('defaultPage.twig');
        } else {
            $this->dpl->addTwigParams(array("message" => "Champs invalides"));
            $this->displayLoginForm();
        }
    }

    public function badAction()
    {
        $this->dpl->useBundle('naskiPage');
        $this->dpl->render('404.twig');
    }

}
