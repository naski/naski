<?php

$template = $IM->twig->loadTemplate('demo/views/home.twig');
echo $template->render(array('demo_var' => 'Hey'));
