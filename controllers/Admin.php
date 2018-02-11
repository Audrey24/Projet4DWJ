<?php

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //Session::init();
        if (!Session::isAuthenticated()) {
            //echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#myModal" id="connexion">Connexion</a>';
            echo "pas connecte";
        }
    }

    public function index()
    {
        $this->view->render('admin/dashboard');
    }
}
