<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class LogoutController extends AbstractController
{
    public function index()
    {
        Auth::getInstance()->doLogout();
        redirect("");
    }
}
