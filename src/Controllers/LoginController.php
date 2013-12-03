<?php
class LoginController{
	public function index(){
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
?>