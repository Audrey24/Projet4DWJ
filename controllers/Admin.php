<?php

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //Session::init();
        if (Session::get('role') == 'admin') {
            $this->index();
        } else {
            header('location: Home.php');
        }
    }

    public function index()
    {
        $this->view->render('admin/dashboard');
    }
}
