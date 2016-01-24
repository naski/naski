<?php

$MUX->get('/', ['HomeController', 'indexAction']);
$MUX->post('/product(/:id)', ['HomeController', 'product']);
