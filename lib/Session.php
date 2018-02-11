<?php

class Session
{
    public static function init()
    {
        session_start();
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

    public static function isAuthenticated()
    {
        return isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === true;
    }
    /*
        public static function setAuthenticated($authenticated = true)
        {
            if (!is_bool($authenticated)) {
                throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
            }
    
            $_SESSION['pseudo'] = $authenticated;
        }*/

    public static function destroy()
    {
        session_destroy();
    }
}
