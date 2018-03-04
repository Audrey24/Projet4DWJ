<?php

class Teaser extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonction qui rend la view associé à la classe
    public function index()
    {
        $this->view->addData($this->model->extractChapter());
        $this->view->render('teaser/extract_chapter', 'lib/images/ecrivain.jpeg');
    }
}
