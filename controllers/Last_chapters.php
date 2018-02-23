<?php

class Last_chapters extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonction qui rend la view associé à la classe
    public function index()
    {
        $this->view->render('last_chapter/chapters', 'lib/images/livre.jpg');
    }

    public function getChapters()
    {
        $this->model->getChapters();
    }
}
