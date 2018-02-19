<?php

class Admin extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
        //Si un visiteur essaye d'accéder à admin, on le redirige vers l'accueil.
        Session::init();
        if (Session::get('role') != 'admin') {
            header('location: home');
        }
    }

    //Fonction qui rend la view associé à la classe
    public function index()
    {
        $this->view->render('admin/dashboard', 'lib/images/plume.jpg');
    }

    //Fonctions qui appellent les fonctions définies dans le model.

    public function create()
    {
        $this->model->create();
    }

    public function textsList()
    {
        $this->model->textsList();
    }

    public function delete($id)
    {
        $this->model->delete($id);
    }

    public function getOne($id)
    {
        $this->model->getOne($id);
    }
}
