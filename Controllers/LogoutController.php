<?php
class LogoutController{
	public function index(){
		Auth::doLogout();
		redirect("");
	}
}
?>