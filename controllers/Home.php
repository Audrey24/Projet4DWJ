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
        $this->view->addData($this->model->getOneNews($id));
        $this->view->render('home/news', 'lib/images/news.jpg');
    }

    //Fonction qui obtient les 5 derniers articles.
    public function getNews()
    {
        $this->model->getNews();
    }
}
