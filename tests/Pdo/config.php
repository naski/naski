<?php

$GLOBALS['DB_MYSQL'] = array(
    'host' => '127.0.0.1',
    'dbname' => 'tests',
    'username' => 'root',
    'password' => 'wugaxu',
);

$GLOBALS['DB_POSTGRES'] = array(
    'host' => '127.0.0.1',
    'dbname' => 'tests',
    'username' => 'postgres',
    'password' => 'wugaxu'
);

//define('SKIP_POSTGRES', true);
define('SKIP_MYSQL', true);
