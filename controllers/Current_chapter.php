<?php

class Current_chapter extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonction qui rend la view associé à la classe
    public function index()
    {
        $this->view->render('current_chapter/current', 'lib/images/chapitre.jpg');
    }

    //Fonctions qui appellent les fonctions définies dans le model.
    public function getLastChapter()
    {
        $this->model->getLastChapter();
    }

    ////Fonction qui rend la vue associé.
    // Ajout des données recupéréres par getOneChapter (un chapitre) dans la page.
    public function read($id_chap)
    {
        $this->view->addData($this->model->getOneChapter($id_chap));
        $this->view->render('current_chapter/reading', 'lib/images/chapitre.jpg');
    }
}
