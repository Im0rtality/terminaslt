<?php

namespace Terminas\Controllers;

use Utils\Auth;

class LogoutController
{
    public function index()
    {
        Auth::doLogout();
        redirect("");
    }
}
