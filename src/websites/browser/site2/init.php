<?php

define('ROOT_SYSTEM_WEBSITE', __DIR__.'/');

global $IM;

$IM->recordInstance('site', $SITE);



$IM->twig->addTwigPath(ROOT_SYSTEM_WEBSITE);

$IM->twig->useBundle('naskiPage');
$IM->twig->render('index.twig');

$db = new \Naski\Pdo\MySQLDatabase($IM->config['main_mysql']);

$users = \Job\User::get($db, array());
echo $users[0]->name;
$users[0]->name = "Go";
$users[0]->save();
