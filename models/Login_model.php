<?php
class Login_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function signin()
    {
        $pseudo = $_POST['pseudo1'];
        $pass = $_POST['password1'];

        $req = $this->db->prepare('SELECT id, pass FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
        'pseudo' => $pseudo));

        $resultat = $req->fetch();

        if (!$resultat) {
            echo 'Mauvais identifiant !';
        } elseif (password_verify($pass, $resultat['pass'])) {
            echo 'Bienvenue !';
        } else {
            echo 'Erreur, mauvais mot de passe ! ';
        }
    }

    public function signup()
    {
        $error = 0;
        $msgs[] = array();

        $pseudo = $_POST['pseudo'];
        $pseudo = htmlspecialchars($pseudo);
        if (!isset($pseudo) || !preg_match("#^[a-z0-9]+$#i", $pseudo)) {
            $msgs["message2"] ="Le pseudo n'est pas valide (aucun signe n'est accepté)";
            $error = 1;
        }

        $email = $_POST['email2'];
        $email = htmlspecialchars($email);
        if (!isset($email) || !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
            $msgs["message3"] = "L'adresse mail n'est pas valide (exemple@bla.com)";
            $error = 1;
        }

        $passbrut = $_POST['password2'];
        $passbrut = htmlspecialchars($passbrut);
        if (!isset($passbrut) || !preg_match("#^[a-z0-9]+$#", $passbrut)) {
            $msgs["message4"] = "Le mot de passe n'est pas valide (doit contenir des chiffres et des lettres, pas de signes)!";
            $error = 1;
        }
        $passbrut = password_hash($passbrut, PASSWORD_DEFAULT);

        if (empty($_POST['pseudo']) ||
                empty($_POST['email2']) ||
                empty($_POST['password2']) ||
                !filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL) ||
                !filter_var(
                    $_POST['pseudo'],
                    FILTER_VALIDATE_REGEXP,
                  array("options"=>array("regexp"=>"#^[a-z0-9]+$#i"))
                )) {
            $msgs["message1"] = "Aucun argument n'a été fourni!";
            $error = 1;
        }


        //On vérifie que les données ne sont pas déjà utilisées dans la bdd.
        $req = $this->db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
                'pseudo' => $pseudo));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            $msgs["message5"] = "Le pseudo est déjà utilisé, veuillez en choisir un nouveau!";
            $error = 1;
        }

        $req = $this->db->prepare('SELECT mail FROM users WHERE mail = :mail');
        $req->execute(array(
                'mail' => $email));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            $msgs["message6"] = "L'adresse mail est déjà utilisée, veuiller recommencer!";
            $error = 1;
        }

        $req = $this->db->prepare('SELECT pass FROM users WHERE pass = :pass');
        $req->execute(array(
                'pass' => $passbrut));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            $msgs["message7"] = "Le mot de passe existe déjà; veuiller en choisir un nouveau !";
            $error = 1;
        }

        //Si les données sont disponibles on les insère dans la bdd.
        if ($error == 0) {
            $req = $this->db->prepare('INSERT INTO users (pseudo, mail, pass) VALUES(:pseudo, :mail, :pass)');
            $req->execute(array(
                  'pseudo' => $pseudo,
                  'mail' => $email,
                  'pass' => $passbrut));
            $msgs["message8"] = "Inscription validée";
        }

        echo json_encode($msgs);
        return true;
    }
}
