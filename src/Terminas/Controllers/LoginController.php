<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class LoginController extends AbstractController
{
    public function index()
    {
        if (Auth::isLoginFieldsSet() === true) {
            if (Auth::doLogin() === true) {
                redirect("");
            } else {
                // render "error invalid login"
            }
        } else {
            // render login form
        }
    }
}
