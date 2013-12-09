<?php

namespace Utils;

class Auth
{
    const FLAG_ADMIN = 1;

    private static $user = null;
    private static $database = null;

    public static function isLoginFieldsSet()
    {
        return isset($_REQUEST['name']) && isset($_REQUEST['pass']);
    }

    public static function isSessionFieldsSet()
    {
        return isset($_SESSION['name']) && isset($_SESSION['pass']);
    }

    public static function isLoggedIn()
    {
        return self::$user !== null;
    }

    public static function hasFlag($flag)
    {
        return self::$user !== null ? (self::$user['flags'] && $flag) != 0 : false;
    }

    public static function doLogin()
    {
        if (self::internalLogin($_REQUEST['name'], sha1($_REQUEST['pass']))) {
            $_SESSION['name'] = self::$user['name'];
            $_SESSION['pass'] = self::$user['password'];

            return true;
        } else {
            return false;
        }
    }

    public static function sessionLogin()
    {
        return self::internalLogin($_SESSION['name'], $_SESSION['pass']);
    }

    private static function internalLogin($username, $password)
    {
        $result = self::$database->select(
            'users',
            array('*'),
            array('name' => $username, 'password' => $password),
            null,
            1
        );
        if (isset($result[0])) {
            self::$user = $result[0];
        }

        return self::isLoggedIn();
    }

    public static function trySessionLogin()
    {
        if (self::isSessionFieldsSet()) {
            return self::sessionLogin();
        } else {
            return false;
        }
    }

    public static function doLogout()
    {
        unset($_SESSION['name']);
        unset($_SESSION['password']);
        self::$user = null;
        session_destroy();
    }

    public static function user($key)
    {
        return self::isLoggedIn() ? self::$user[$key] : null;
    }

    /**
     * @param null $database
     */
    public static function setDatabase($database)
    {
        self::$database = $database;
    }
}
