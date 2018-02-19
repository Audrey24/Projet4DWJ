<?php

class Controller
{
    public function __construct()
    {
        //On range la vue dans l'attr 'view' de l'objet controller.
        $this->view = new View();
    }

    public function LoadModel($name)
    {
        //Retire .php des noms car parfois PHP le rajoutait ( index.php.php)
        $name = rtrim($name, '.php');
        //Création d'une variable contenant le chemin du model passé en paramètre (voir Router)
        $path = "models/" . $name. "_model.php";

        //Vérification de l'existence du fichier.
        if (file_exists($path)) {
            require "models/" . $name. "_model.php";
            //s'il existe, on range le model associé dans l'att "model" de l'objet controller.
            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }
}
