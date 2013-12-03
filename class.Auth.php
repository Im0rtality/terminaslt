<?php
class Auth {
	const FLAG_ADMIN = 1;

	private static $user = null;

	public static function isLoginFieldsSet() {
		return isset( $_REQUEST['name'] ) && isset( $_REQUEST['pass'] );
	}

	public static function isSessionFieldsSet() {
		return isset( $_SESSION['name'] ) && isset( $_SESSION['pass'] );
	}

	public static function isLoggedIn() {
		return Auth::$user !== null;
	}

	public static function hasFlag( $flag ) {
		return Auth::$user !== null ? ( Auth::$user['flags'] && $flag ) != 0 : false;
	}

	public static function doLogin() {
		if ( Auth::internalLogin( $_REQUEST['name'], sha1( $_REQUEST['pass'] ) ) ) {
			$_SESSION['name'] = Auth::$user['name'];
			$_SESSION['pass'] = Auth::$user['password'];
			return true;
		} else {
			return false;
		}
	}

	public static function sessionLogin() {
		return Auth::internalLogin( $_SESSION['name'], $_SESSION['pass'] );
	}

	private static function internalLogin( $username, $password ) {
		global $DB;
		$result = $DB->select( 'users', array( '*' ), array( 'name' => $username, 'password' => $password ), null, 1 );
		if ( isset( $result[0] ) ) {
			Auth::$user = $result[0];
		}
		return Auth::isLoggedIn();
	}

	public static function trySessionLogin() {
		if ( Auth::isSessionFieldsSet() ) {
			return Auth::sessionLogin();
		} else {
			return false;
		}
	}

	public static function doLogout() {
		unset( $_SESSION['name'] );
		unset( $_SESSION['password'] );
		Auth::$user = null;
		session_destroy();
	}

	public static function user( $key ) {
		return Auth::isLoggedIn() ? Auth::$user[$key] : null;
	}
}
?>
