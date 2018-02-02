<?php

class User
{
    protected $name;
    protected $mail;
    protected $pass;
    protected $error;

    //ACCESSEURS/GETTERS
    // Ceci est la méthode name() : elle se charge de renvoyer le contenu de l'attribut $name.
    public function name()
    {
        return $this->name;
    }

    // Ceci est la méthode mail() : elle se charge de renvoyer le contenu de l'attribut $mail.
    public function mail()
    {
        return $this->mail;
    }

    // Ceci est la méthode pass() : elle se charge de renvoyer le contenu de l'attribut $pass.
    public function pass()
    {
        return $this->pass;
    }


    //MUTATEURS/SETTERS
    // Vérification de la validité des informations
    //On vérifie que les champs sont remplis et valides.
    public function setPseudo($pseudo)
    {
        $pseudo = htmlspecialchars($pseudo);
        if (!isset($pseudo) || !preg_match("#^[a-z0-9]+$#i", $pseudo)) {
            $this->error = 'Le ' . $pseudo . ' est pas <strong>valide</strong> !';
            return false;
        }
        $this->name = $pseudo;
        return true;
    }

    public function setEmail($email)
    {
        $email = htmlspecialchars($email);
        if (!isset($email) || !preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
            $this->error = 'Le ' . $email . ' est pas <strong>valide</strong> !';
            return false;
        }
        $this->mail = $email;
        return true;
    }

    public function setPass($passbrut)
    {
        $passbrut = htmlspecialchars($passbrut);
        if (!isset($passbrut) || !preg_match("#^[a-z0-9]+$#", $passbrut)) {
            $this->error = 'Le ' . $passbrut . ' est pas <strong>valide</strong> Il doit contenir des chiffres et des lettres!';
            return false;
        }
        $this->pass = password_hash($passbrut, PASSWORD_DEFAULT);
        return true;
    }

    //Constructeur de la classe
    public function __construct($pseudo, $mail, $pass)
    {
        if (!$this->setPseudo($pseudo) || !$this->setEmail($mail) || !$this->setPass($pass)) {
            echo $this->error;
            return false;
        } else {
            echo "Inscription validée ! Bienvenue <strong>$pseudo</strong> et bonne lecture !";
        }
    }

    public function connect($mail, $pass)
    {
    }

    //Fonction qui gère l'inscription
    public function signup($bdd)
    {
        //On vérifie que les données ne sont pas déjà utilisées dans la bdd.
        $req = $bdd->prepare('SELECT pseudo FROM test WHERE pseudo = :pseudo');
        $req->execute(array(
          'pseudo' => $this->name));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            echo "Le pseudo est déjà utilisé";
            return false;
        }

        $req = $bdd->prepare('SELECT mail FROM test WHERE mail = :mail');
        $req->execute(array(
          'mail' => $this->mail));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            echo "Le mail est déjà utilisé";
            return false;
        }

        $req = $bdd->prepare('SELECT pass FROM test WHERE pass = :pass');
        $req->execute(array(
          'pass' => $this->pass));
        // recherche de résultat
        $res = $req->fetch();

        if ($res) {
            echo "Le mdp est déjà utilisé";
            return false;
        }

        //Si les données sont disponibles on les insère dans la bdd.
        $req = $bdd->prepare('INSERT INTO test (pseudo, mail, pass) VALUES(:pseudo, :mail, :pass)');
        $req->execute(array(
          'pseudo' => $this->name,
          'mail' => $this->mail,
          'pass' => $this->pass));
    }
}
