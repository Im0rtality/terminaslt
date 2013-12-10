<?php

namespace Utils;

class Auth
{
    const FLAG_ADMIN = 1;

    private $user = null;
    /** @var $database Database */
    private $database = null;
    private static $instance = null;

    public function isLoginFieldsSet()
    {
        return isset($_REQUEST['name']) && isset($_REQUEST['pass']);
    }

    public function isSessionFieldsSet()
    {
        return isset($_SESSION['name']) && isset($_SESSION['pass']);
    }

    public function isLoggedIn()
    {
        return $this->user !== null;
    }

    public function hasFlag($flag)
    {
        return ($this->user !== null) ? ($this->user['flags'] && $flag) != 0 : false;
    }

    public function doLogin()
    {
        if ($this->internalLogin($_REQUEST['name'], sha1($_REQUEST['pass']))) {
            $_SESSION['name'] = $this->user['name'];
            $_SESSION['pass'] = $this->user['password'];

            return true;
        } else {
            return false;
        }
    }

    public function sessionLogin()
    {
        return $this->internalLogin($_SESSION['name'], $_SESSION['pass']);
    }

    private function internalLogin($username, $password)
    {
        $result = $this->database->select(
            'users',
            array('*'),
            array('name' => $username, 'password' => $password),
            null,
            1
        );
        if (isset($result[0])) {
            $this->user = $result[0];
        }

        return $this->isLoggedIn();
    }

    public function trySessionLogin()
    {
        if ($this->isSessionFieldsSet()) {
            return $this->sessionLogin();
        } else {
            return false;
        }
    }

    public function doLogout()
    {
        unset($_SESSION['name']);
        unset($_SESSION['password']);
        $this->user = null;
        session_destroy();
    }

    public function user($key)
    {
        return self::isLoggedIn() ? $this->user[$key] : null;
    }

    /**
     * @param null $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return Auth
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Auth();
        }
        return self::$instance;
    }
}
