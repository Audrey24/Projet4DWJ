<?php

class Admin extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
        //Si un visiteur essaye d'accéder à admin, on le redirige vers l'accueil.
        Session::init();
        if (Session::get('role') != 'admin' && Session::get('role') != 'moderateur') {
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

    public function textsList($type)
    {
        $this->model->textsList($type);
    }

    public function delete()
    {
        $this->model->delete();
    }

    public function deleteAJAX()
    {
        $this->model->deleteAJAX();
    }

    public function getOne()
    {
        $this->model->getOne();
    }

    public function getDislike($type)
    {
        $this->model->getDislike($type);
    }

    public function getComments($type)
    {
        $this->model->getComments($type);
    }

    public function deleteComments()
    {
        $this->model->deleteComments();
    }

    public function validComments()
    {
        $this->model->validComments();
    }
}
