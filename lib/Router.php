<?php
class Router
{
    public function __construct()
    {
        //Traitement des URL
        //On vérifie qu'elles soient remplies.
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        //On retire le potentiel dernier slash.
        $url = rtrim($url, '/');
        //On découpe les éléments de l'URl en fonction des slashs.
        $url = explode('/', $url);

        //Si l'url0 est vide, on affiche Home par défaut et on retourne la view associé.
        if (empty($url[0])) {
            require 'controllers/Home.php';
            $controller = new Home();
            $controller->index();
            return false;
        }

        //On retire .php de nom contenu dans Url0.
        $url[0] = rtrim($url[0], '.php');
        //On écrit toujours ce nom avec un majuscule.
        $url[0] = ucfirst($url[0]);
        //On met dans une var le chmein pour accéder au controller demandé.
        $file = 'controllers/' . $url[0] . '.php';
        //Si le fichier existe, on renvoit le fichier et sinon on renvoit sur la page erreur.
        if (file_exists($file)) {
            require $file;
        } else {
            $this->error();
            return false;
        }

        //Instanciation du controller et du model associé.
        $controller = new $url[0];
        $controller->loadModel($url[0]);

        //Si le paramètre du Url2 est rempli et que la méthode de l'Url1 existe,
        //on effectue sur le controller(url0) la méthode(url1) avec le paramètre(url2).
        //Sinon on renvoit sur la page de Chuck Norris.
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
                return false;
            }
        } else {
            //On vérifie que la méthode de l'Url1 est remplie.
            // Si elle existe, on l'effectue sur le controller, sinon page erreur avec Chuck Norris.
            //Si elle n'est pas remplie, on effectue la méthode qui renvoit la vue (méthode par défaut).
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    $this->error();
                    return false;
                }
            } else {
                $controller->index();
            }
        }
    }

    //Fontion qui appelle le controller Erreur et qui affiche la vue associée.
    public function error()
    {
        require_once "controllers/Errorme.php";
        $controller = new Errorme();
        $controller->index();
        return false;
    }
}
