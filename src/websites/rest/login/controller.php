<?php

use Naski\Controller;
use Job\User;

class LoginController extends Controller
{

    public function loginAction($user, $password)
    {
        echo (User::goodLogin($user, $password)) ? "YES" : "NO";
    }

    public function noAction()
    {
        echo "WS Login";
    }
}
