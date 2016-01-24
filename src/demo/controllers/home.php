<?php

use Naski\Controller;

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

    public function product()
    {
        $this->gump->validation_rules(array(
            'username'    => 'required|alpha_numeric|max_len,100|min_len,6',
            'password'    => 'required|max_len,100|min_len,6',
            'email'       => 'required|valid_email',
            'gender'      => 'required|exact_len,1|contains,m f',
            'credit_card' => 'required|valid_cc'
        ));

        $this->gump->filter_rules(array(
            'username' => 'trim|sanitize_string',
            'password' => 'trim',
            'email'    => 'trim|sanitize_email',
            'gender'   => 'trim',
            'bio'      => 'noise_words'
        ));

        $validated_data = $this->gump->run($_POST);

        if ($validated_data === false) {
            echo "Erreur, formulaire invalide";
        } else {
            print_r($validated_data); // validation successful
        }
    }
}
