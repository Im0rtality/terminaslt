<?php
include '../vendor/autoload.php';

use Utils\Auth;
use Utils\FrontController;
use Utils\HtmlHelper;
use Utils\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);
define('WEB_ROOT', __DIR__);
define('ROOT', dirname(WEB_ROOT));
define('WEBSITE_ROOT', '/');
define('ASSETS_ROOT', WEBSITE_ROOT . 'assets/');

function debug($var)
{
    echo "<pre>" . print_r($var, true) . "</pre>";
}

function isCallable($class_name, $method_name, $static = false)
{
    if (!is_string($class_name)) {
        $class_name = get_class($class_name);
    }

// Define Callable
    if ($static) {
        $callable = "{$class_name}::{$method_name}";
    } else {
        $callable = array($class_name, $method_name);
    }


// Check class itself
    if (@is_callable($callable) === true) {
        if ($method_name == 'setEmailAddressTypeHash') {
            ErrorHandler::preDump($callable);
        }

        return true;
    }

// Check all parents
    while ($parent_class = get_parent_class($class_name)) {
        if (@is_callable($callable) === true) {
            return true;
        }
        $class_name = $parent_class;
    }

    return false;
}

function redirect($url)
{
    header("Location: " . '/' . $url);
    exit;
}

$request = new Request();
$front   = new FrontController(true, $request);
$front->setHtmlHelper(new HtmlHelper());
$front->initDatabase('database.config.php');
session_start();
Auth::trySessionLogin();
$front->handleRoute($_GET);
$front->renderView();
