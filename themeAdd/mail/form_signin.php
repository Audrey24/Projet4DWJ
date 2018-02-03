<?php
// Check for empty fields
try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}

$error = 0;

if (empty($_POST['pseudo']) || empty($_POST['email2']) || empty($_POST['password2']) || !filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(
     array(
       "message" => "Aucun argument n'a été fourni!"
     )
   );
    $error = 1;
}

$pseudo = $_POST['pseudo'];
$email = $_POST['email2'];
$passbrut = $_POST['password2'];

$pseudo = htmlspecialchars($pseudo);
  if (!isset($pseudo) || !preg_match("#^[a-z0-9]+$#i", $pseudo)) {
      echo json_encode(
      array(
        "message2" => "pseudo faux"
      )
    );
      $error = 1;
  }

$email = htmlspecialchars($email);
  if (!isset($email) || !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
      echo json_encode(
      array(
        "message3" => "mail faux"
      )
    );
      $error = 1;
  }

$passbrut = htmlspecialchars($passbrut);
  if (!isset($passbrut) || !preg_match("#^[a-z0-9]+$#", $passbrut)) {
      echo json_encode(
      array(
        "message4" => "mdp faux!"
      )
    );
      $error = 1;
  }
  $passbrut = password_hash($passbrut, PASSWORD_DEFAULT);

  //On vérifie que les données ne sont pas déjà utilisées dans la bdd.
  $req = $bdd->prepare('SELECT pseudo FROM test WHERE pseudo = :pseudo');
  $req->execute(array(
    'pseudo' => $pseudo));
  // recherche de résultat
  $res = $req->fetch();

  if ($res) {
      echo json_encode(
      array(
        "message5" => "deja utilise pseudo!"
      )
    );
      $error = 1;
  }

  $req = $bdd->prepare('SELECT mail FROM test WHERE mail = :mail');
  $req->execute(array(
    'mail' => $email));
  // recherche de résultat
  $res = $req->fetch();

  if ($res) {
      echo json_encode(
      array(
        "message6" => "mail deja pris!"
      )
    );
      $error = 1;
  }

  $req = $bdd->prepare('SELECT pass FROM test WHERE pass = :pass');
  $req->execute(array(
    'pass' => $passbrut));
  // recherche de résultat
  $res = $req->fetch();

  if ($res) {
      echo json_encode(
      array(
        "message7" => "mdp dejq pris"
      )
    );
      $error = 1;
  }

  //Si les données sont disponibles on les insère dans la bdd.
  if ($error == 0) {
      $req = $bdd->prepare('INSERT INTO test (pseudo, mail, pass) VALUES(:pseudo, :mail, :pass)');
      $req->execute(array(
      'pseudo' => $pseudo,
      'mail' => $email,
      'pass' => $passbrut));
      echo json_encode(
        array(
          "message8" => "enregistrés"
        )
      );
  }

return true;
