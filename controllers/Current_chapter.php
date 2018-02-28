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

    public function no_read()
    {
        $this->view->render('current_chapter/no_read', 'lib/images/chapitre.jpg');
    }

    public function commentChapter()
    {
        $this->model->commentChapter();
    }

    public function getCommentsChapter()
    {
        $this->model->getCommentsChapter();
    }

    public function delete_commentsChapter($id)
    {
        $this->model->delete_commentsChapter($id);
    }

    public function dislikeComment()
    {
        $this->model->dislikeComment();
    }

    public function prev()
    {
        $this->model->prev();
    }

    public function next()
    {
        $this->model->next();
    }
}
