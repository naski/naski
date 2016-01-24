<?php


require_once 'boot.php';

// Démo

require '../src/demo/controllers/home.php';

$ctrl = new Job\HomeController();
// $ctrl->indexAction();


require_once '../core/debug_bar/show.php';
