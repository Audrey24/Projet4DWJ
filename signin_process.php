<?php

require('User.php');

try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}

$user = new User($_POST['pseudo2'], $_POST['mail22'], $_POST['pass22']);
$user->signup($bdd);



// Vérification de la validité des informations
//On vérifie que les champs sont remplis et valides.
