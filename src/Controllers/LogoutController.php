<?php

namespace Terminas\Controller;

use Utils\Auth;

class LogoutController
{
    public function index()
    {
        Auth::doLogout();
        redirect("");
    }
}
