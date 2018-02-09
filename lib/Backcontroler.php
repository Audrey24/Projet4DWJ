<?php

namespace P4Fram;

class Factory
{
    public static function getMysqlConnexion()
    {
        try {
            $db = new \PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : '.$e->getMessage());
        }

        return $db;
    }
}


/*
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}*/
