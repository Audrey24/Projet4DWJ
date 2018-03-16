<?php
class Login_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonction de connexion.
    public function signin()
    {
        //Déclaration des var.
        $error = 0;
        $msgs[] = array();

        $pseudo = $_POST['pseudo1'];
        $pass = $_POST['password1'];

        //Comparaison des données saisies avec celles de la Bdd.
        $req = $this->db->prepare('SELECT id, pass, role, read_chapter, read_page FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
        'pseudo' => $pseudo));

        $resultat = $req->fetch();

        //Appel de la fonction pour compter le nb de tentatives de connexion.
        Session::trySignin();
        $max = 3;
        $val = $max - Session::get('tries') +1;

        //Si erreur de pseudo ou mdp, msg d'erreur qui s'affiche + décompte de nombre d'essais restants.
        //Sinon connexion et création d'une session(qui récupère le pseudo et le rôle).
        if (Session::get('tries') > $max) {
            $msgs['message13'] = "Vous avez dépassé le nombre de tentative de connexion. Veuillez réesayer daans 30 min.";
            $error = 1;
        } elseif (!$resultat) {
            $msgs["message10"] = " Erreur, mauvais identifiant ! Il vous reste " .  $val . " essais ";
            $error = 1;
        } elseif (password_verify($pass, $resultat['pass'])) {
            $msgs["message12"] =" Bienvenue " . $pseudo . ", bonne visite !";
            Session::init(); //sans ceci cela ne marche pas
            Session::authenticate($resultat['role'], $pseudo, $resultat['id'], $resultat['read_chapter'], $resultat['read_page']);
        } else {
            $msgs["message11"] =" Erreur, mauvais mot de passe !  Il vous reste " .  $val . " essais " ;
            $error = 1;
        }
        //Retourne les msgs sous forme d'objets JSON pour pouvoir les traiter en JS.
        echo json_encode($msgs);
        return true;
    }

    // Fonction pour l'inscription.
    public function signup()
    {
        $error = 0;
        $msgs[] = array();
        $secret = '6LdjZkMUAAAAAGEU0LnnUXfuOCx-XrylQGKARHXs';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['recaptcha']);
        $responseData = json_decode($verifyResponse);

        if ($responseData->success != 1) {
            $msgs["message8"] = "Vous avez tenté de créer trop de comptes en peu de temps ! Veuillez recommencer plus tard ! ";
            $error = 1;
        }

        //On vérifie si le champs est rempli et la validité du pseudo. Si pb, on retourne un msg d'erreur.
        $pseudo = $_POST['pseudo'];
        //Convertit les caractères spéciaux en entités HTML.
        $pseudo = htmlspecialchars($pseudo);
        if (!isset($pseudo) || !preg_match("#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ@_&]{3,16}+$#i", $pseudo)) {
            $msgs["message2"] ="Le pseudo n'est pas valide : il doit contenir entre 3 et 16 caractères et se composer de chiffres, de lettres, de lettres accentués ou de ces signes : @  _ &";
            $error = 1;
        }

        //On vérifie si le champs est rempli et la validité de l'email. Si pb, on retourne un msg d'erreur.
        $email = $_POST['email2'];
        //Convertit les caractères spéciaux en entités HTML.
        $email = htmlspecialchars($email);
        if (!isset($email) || !preg_match("#^[a-z0-9._-]+@[a-z0-9._\-]{2,10}\.[a-z]{2,4}$#i", $email)) {
            $msgs["message3"] = "L'adresse mail n'est pas valide, elle doit se composer comme ceci : exemple@bla.com";
            $error = 1;
        }

        //On vérifie si le champs est rempli et la validité du mdp. Si pb, on retourne un msg d'erreur.
        $passbrut = $_POST['password2'];
        //Convertit les caractères spéciaux en entités HTML.
        $passbrut = htmlspecialchars($passbrut);
        if (!isset($passbrut) || !preg_match("#^[a-z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ@_&/(){}]{3,16}+$#", $passbrut)) {
            $msgs["message4"] = "Le mot de passe n'est pas valide : il doit contenir entre 3 et 16 caractères et se composer de chiffres, de lettres ou de ces signes : _ & / () {} )";
            $error = 1;
        }
        //Hachage du mdp pour le sécuriser.
        $passbrut = password_hash($passbrut, PASSWORD_DEFAULT);

        //Si un des champs est vide, msg d'erreur.
        if (empty($_POST['pseudo']) ||
                empty($_POST['email2']) ||
                empty($_POST['password2']) ||
                !filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL)) {
            $msgs["message1"] = "Aucune donnée n'a été fournie !";
            $error = 1;
        }


        //On vérifie que les données ne sont pas déjà utilisées dans la bdd.
        //Si on a un résultat, cela veut dire qu'il est déjà utilisé donc msg d'erreur.
        $req = $this->db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
                'pseudo' => $pseudo));

        $res = $req->fetch();
        if ($res) {
            $msgs["message5"] = "Le pseudo est déjà utilisé, veuillez en choisir un nouveau!";
            $error = 1;
        }

        $req = $this->db->prepare('SELECT mail FROM users WHERE mail = :mail');
        $req->execute(array(
                'mail' => $email));

        $res = $req->fetch();
        if ($res) {
            $msgs["message6"] = "L'adresse mail est déjà utilisée, veuiller recommencer!";
            $error = 1;
        }

        $req = $this->db->prepare('SELECT pass FROM users WHERE pass = :pass');
        $req->execute(array(
                'pass' => $passbrut));

        $res = $req->fetch();
        if ($res) {
            $msgs["message7"] = "Le mot de passe existe déjà; veuiller en choisir un nouveau !";
            $error = 1;
        }

        //Si les données sont disponibles, on les insère dans la bdd et on début une session.
        if ($error == 0) {
            try {
                $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $req = $this->db->prepare('INSERT INTO users (pseudo, mail, pass, role) VALUES(:pseudo, :mail, :pass, :role)');
                $req->execute(array(
                  'pseudo' => $pseudo,
                  'mail' => $email,
                  'pass' => $passbrut,
                  'role' => "visiteur"));
                $msgs["message9"] = "L'inscription est validée, bienvenue sur notre site " . $pseudo;
                Session::init();
                Session::authenticate('visiteur', $pseudo, $this->db->lastInsertId());
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        echo json_encode($msgs);
        return true;
    }

    //Fonction de déconnexion qui détruit la session.
    public function disconnect()
    {
        //Réinitialisatin de la session ( lui assigner un array vide = la remettre à 0)
        $_SESSION = array();

        //On modifie les paramètres du cookie de session pour pouvoir la supprimer.
        if (ini_get('session.use_cookies')) {
            $param = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000, $param['path'], $param['domain'], $param['secure']);
        }
        //Suppression et redirection.
        session_destroy();
        header('Location: ../home');
    }

    public function generateLog()
    {
        $mail = $_POST['mail'];

        $req = $this->db->prepare('SELECT id FROM users WHERE mail = :mail');
        $req->execute(array(
        "mail" => $mail));
        $res = $req->fetch();

        $hash = md5(random_bytes(16));

        $req = $this->db->prepare('INSERT INTO  recovery_login (id_user, hash) VALUES(:id_user, :hash)');
        $req->execute(array(
              'id_user' => $res['id'],
              'hash' => $hash ));

        $body = "Vous avez demandé une réinitialisation de votre mot de passe.\n\n"."Veuillez suivre ce lien pour choisir votre nouveau mot de passe:\n\n". "http://projet3.projetsdwjguilloux.ovh/projet_4/Login/recovery/" . $hash ."";
        $headers = "From: noreply@yprojetsdwjguilloux.ovh\n";
        $headers .= "Reply-To: noreply@yprojetsdwjguilloux.ovh\n" ;

        mail($mail, "Demande de récupération de mot de passe", $body, $headers);
    }

    public function recovery($hash)
    {
        $req = $this->db->prepare('SELECT id_user FROM recovery_login WHERE hash = :hash');
        $req->execute(array(
              'hash' => $hash));
        $res = $req->fetch();
        return $res;
    }

    public function updateLog()
    {
        $id = $_POST['id'];
        $pass = $_POST['pass'];
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $req = $this->db->prepare('UPDATE users SET  pass = :pass WHERE id = :id');
        $req->execute(array(
        'id' => $id,
        'pass' => $pass));

        $req = $this->db->prepare('DELETE FROM recovery_login WHERE id_user = :id_user');
        $req->execute(array(
        'id_user' => $id));
    }
}
