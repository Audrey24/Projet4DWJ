<?php

class Session
{
    //S'il n'y a pas de session en cours, on en débute une.
    public static function init()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    //On assigne une valeur à une clé.
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    //Si la clé est remplit, on la renvoit.
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    //Associe valeurs des var pseudo et rôle aux clés correspondant.
    public static function authenticate($role, $pseudo, $id, $read_chapter = null, $read_page=null)
    {
        Session::set('pseudo', $pseudo);
        Session::set('role', $role);
        Session::set('id', $id);
        Session::set('read_chapter', $read_chapter);
        Session::set('read_page', $read_page);
    }

    //Compte le nombre d'essai
    public static function trySignin()
    {
        //On débute une session.
        session_start();
        //Si la clé n'est pas remplit alors elle équivaut à 1 car il s'agit du premier essai.
        if (!isset($_SESSION['tries'])) {
            $_SESSION['tries'] = 1;
        } else {
            //Sinon on incrémente d'un.
            $_SESSION['tries'] = $_SESSION['tries'] +1;
        }
        //Quand on dépasse les trois essais, dernier essai qui affiche un msg ( voir Login_model)
        if ($_SESSION['tries'] > 3) {
            $_SESSION['tries'] = 4;
        }
    }

    //Destruction de la session.
    public static function destroy()
    {
        session_destroy();
    }
}
