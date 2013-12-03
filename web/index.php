<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function debug( $var ) {
	echo "<pre>" . print_r( $var, true ) . "</pre>";
}

function isCallable( $class_name, $method_name, $static = false ) {
	if ( !is_string( $class_name ) ) {
		$class_name = get_class( $class_name );
	}

// Define Callable
	if ( $static ) {
		$callable = "{$class_name}::{$method_name}";
	}else {
		$callable = array( $class_name, $method_name );
	}


// Check class itself
	if ( @is_callable( $callable ) === true ) {
		if ( $method_name == 'setEmailAddressTypeHash' ) {
			ErrorHandler::preDump( $callable );
		}
		return true;
	}

// Check all parents
	while ( $parent_class = get_parent_class( $class_name ) ) {
		if ( @is_callable( $callable ) === true ) {
			return true;
		}
		$class_name = $parent_class;
	}

	return false;
}

function setViewVar( $var, $value ) {
	global $viewVars;
	$viewVars[$var] = $value;
}

function renderView() {
	global $sView, $viewVars;
	foreach ( $viewVars as $key => $value ) {
		$$key = $value;
	}
	require_once $sView;
}

function redirect( $url ) {
	header( "Location: " . WEB_ROOT . $url );
	exit;
}

function url($controller, $action = "", $params = "") {
	global $useModRewrite;
	if (isset($useModRewrite)) {
		return WEB_ROOT . (empty($controller) ? "" : $controller . '/') . (empty($action) ? "" : $action . '/')  . (empty($params) ? "" : $params . '/') ;
	} else {
		return WEB_ROOT . "index.php?controller=$controller&action=$action" . (empty($params) ? "" : '/' . $params);
	}
}

include '../src/Utils/Database.php';
include '../src/Utils/Auth.php';
$database = new Database( 'localhost', 'terminas', 'terminas', 'terminaslt' );
$useModRewrite = true;

session_start();
Auth::trySessionLogin();

$viewVars = array();

$controller = isset( $_GET['controller'] ) ? $_GET['controller'] : "";
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
define( 'WEB_ROOT', rtrim( $_SERVER['PHP_SELF'], 'index.php' ) );
define( 'ASSETS_ROOT', WEB_ROOT . 'assets/' );

$sCtrl = empty( $controller ) ? "Home" : ucfirst( $controller );
$sClass = sprintf( "%sController", $sCtrl );
$sFile = sprintf( "../src/Controllers/%s.php", $sClass );
if ( file_exists( $sFile ) ) {
	require_once $sFile;
	$ctrl = new $sClass();
	$action = explode( '/', $action );
	$method = array_shift( $action );
	$method = empty( $method ) ? 'index' : strtolower( $method );

	if ( isCallable( $ctrl, $method ) ) {
		switch ( count( $action ) ) {
			case 0:
			$ctrl->$method();
			break;
			case 1:
			$ctrl->$method( $action[0] );
			break;
			case 2:
			$ctrl->$method( $action[0], $action[1] );
			break;
			case 3:
			$ctrl->$method( $action[0], $action[1], $action[2] );
			break;
			default:
			die( "Too many parameters for {$sClass}->{$method}()" );
			break;
		}
		if ( !isset( $viewVars['dontRenderView'] ) ) {
			$sView = sprintf( "../src/Views/%s/%s.php", $sCtrl, $method );
			if ( file_exists( $sView ) ) {
				$title = 'Terminas.lt';
				if ( isset( $viewVars['dontRenderDefault'] ) ) {
					renderView();
				} else {
					require_once "../src/Views/Layout/default.php";
				}
			} else {
	//			redirect();
				die( "View for {$sClass}->{$method}() not found in '{$sView}'" );
			}
		}
	} else {
//		redirect('/');
		die( "Action '{$method}' not found in controller '{$sClass}'" );
	}
} else {
//	redirect('/');
	die( "Controller '{$sClass}' not found in file '{$sFile}'" );
}
?>
