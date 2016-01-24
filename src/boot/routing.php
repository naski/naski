<?php

$MUX->get('/', ['HomeController', 'indexAction']);
$MUX->get('/product(/:id)', ['HomeController', 'product']);
