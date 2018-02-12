<?php

class Session
{
    public static function init()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function authenticate($role, $pseudo)
    {
        Session::set('pseudo', $pseudo);
        Session::set('role', $role);
    }

    public static function trySignin()
    {
        session_start();
        if (!isset($_SESSION['tries'])) {
            $_SESSION['tries'] = 1;
        } else {
            $_SESSION['tries'] = $_SESSION['tries'] +1;
        }
        if ($_SESSION['tries'] > 3) {
            $_SESSION['tries'] = 4;
        }
    }

    public static function destroy()
    {
        session_destroy();
    }
}
