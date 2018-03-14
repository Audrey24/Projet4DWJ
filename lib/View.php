<?php
class View
{
    public function __construct()
    {
    }

    //Fonction pour l'affichage des vues qui rend une vue, une image, le header et le footer.
    public function render($name, $img = null, $noInclude = false)
    {
        //Si le paramètre img est définit, on l'insère dans la var qui se trouve dans le header.
        if (!empty($img)) {
            $backgroundImg = $img;
        } else {
            //sinon on rend pas défaut cette image.
            $backgroundImg = 'lib/images/plume.jpg';
        }

        // Si on ne veut pas afficher le header ou footer, on rend seulement la vue.
        if ($noInclude == true) {
            $name = rtrim($name, '.php');
            require 'views/'. $name . '.php';
        } else {
            //sinon on rend la vue, le header et le footer.
            $name = rtrim($name, '.php');
            require 'views/header.php';
            require 'views/'. $name . '.php';
            require 'views/footer.php';
        }
    }

    //Fonction pour rajouter des données sur une vue ( voir controller Home)
    public function addData($data)
    {
        $this->data = $data;
    }
}
