<?php

$MUX->get('/', ['HomeController', 'indexAction']);
$MUX->post('/product', ['HomeController', 'product']);
