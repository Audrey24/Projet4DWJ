<?php

class Home extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonction qui rend la view associé à la classe
    public function index()
    {
        $this->view->render('home/index', 'lib/images/plume.jpg');
    }

    //Fonction qui rend la vue associé
    // Ajout des données recupéréres par getOneNews (un article) dans la page.
    public function news($id)
    {
        $news = $this->model->getOneNews($id);
        if (!empty($news)) {
            $this->view->addData($news);
            $this->view->render('home/news', 'lib/images/news.jpg');
        } else {
            $this->view->render('errorme/errorpage', 'lib/images/erreur.jpg');
        }
    }

    //Fonction pour commenter
    public function comments()
    {
        $this->model->comments();
    }

    //Fonction qui obtient les 5 derniers articles.
    public function getNews()
    {
        $this->model->getNews();
    }

    //Fonction qui obtient les 20 derniers commentaires.
    public function getComments()
    {
        $this->model->getComments();
    }

    //Fonction pour supprimer les commentaires.
    public function delete_comments($id)
    {
        $this->model->delete_comments($id);
    }

    public function dislikeComments()
    {
        $this->model->dislikeComments();
    }
}
