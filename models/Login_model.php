<?php
class Login_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function signin()
    {
        $error = 0;
        $msgs[] = array();

        $pseudo = $_POST['pseudo1'];
        $pass = $_POST['password1'];

        $req = $this->db->prepare('SELECT id, pass FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
        'pseudo' => $pseudo));

        $resultat = $req->fetch();

        if (!$resultat) {
            $msgs["message10"] ="Mauvais identifiant !";
            $error = 1;
        } elseif (password_verify($pass, $resultat['pass'])) {
            $msgs["message12"] ="Bienvenue " . $pseudo . ", bonne visite !";
            Session::init(); //sans ceci cela ne marche pas
            Session::set('pseudo', $pseudo);
        } else {
            $msgs["message11"] ="Erreur, mauvais mot de passe ! ";
            $error = 1;
        }

        echo json_encode($msgs);
        return true;
    }




    public function signup()
    {
        $error = 0;
        $msgs[] = array();

        $pseudo = $_POST['pseudo'];
        $pseudo = htmlspecialchars($pseudo);
        if (!isset($pseudo) || !preg_match("#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ@\-_&]{3,16}+$#\i", $pseudo)) {
            $msgs["message2"] ="Le pseudo n'est pas valide : il doit contenir entre 3 et 16 caractères et se composer de chiffres, de lettres, de lettres accentués ou de ces signes : @ - _ &";
            $error = 1;
        }

        $email = $_POST['email2'];
        $email = htmlspecialchars($email);
        if (!isset($email) || !preg_match("#^[a-z0-9._-]+@[a-z0-9._\-]{2,}\.[a-z]{2,4}$#", $email)) {
            $msgs["message3"] = "L'adresse mail n'est pas valide, elle doit se composer comme ceci : exemple@bla.com";
            $error = 1;
        }

        $passbrut = $_POST['password2'];
        $passbrut = htmlspecialchars($passbrut);
        if (!isset($passbrut) || !preg_match("#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ@\-_&/(){}]{3,16}+$#", $passbrut)) {
            $msgs["message4"] = "Le mot de passe n'est pas valide : il doit contenir entre 3 et 16 caractères et se composer de chiffres, de lettres ou de ces signes : - _ & / () {} )";
            $error = 1;
        }
        $passbrut = password_hash($passbrut, PASSWORD_DEFAULT);

        if (empty($_POST['pseudo']) ||
                empty($_POST['email2']) ||
                empty($_POST['password2']) ||
                !filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL)) {
            $msgs["message1"] = "Aucune donnée n'a été fournie !";
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
            $msgs["message8"] = "L'inscription est validée, bienvenue sur notre site " . $pseudo;
            Session::init();
            Session::set('pseudo', $pseudo);
        }

        echo json_encode($msgs);
        return true;
    }

    public function disconnect()
    {
        $_SESSION = array();

        if (ini_get('session.use_cookies')) {
            $param = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000, $param['path'], $param['domain'], $param['secure']);
        }

        session_destroy();

        header('Location: ../home');
    }
}
