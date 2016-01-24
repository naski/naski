<?php

namespace Job;

use Naski\Controller;

class HomeController extends Controller {

    public function indexAction() {
        $template = $this->twig->loadTemplate('demo/views/home.twig');
        echo $template->render(array(
            'demo_var' => 'Hey',
            "display" => $this->config->env
        ));
    }
}
