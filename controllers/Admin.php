<?php

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Session::init();
        if (Session::get('role') != 'admin') {
            header('location: home');
        }
    }

    public function index()
    {
        $this->view->render('admin/dashboard', 'lib/images/plume.jpg');
    }

    public function create()
    {
        $this->model->create();
    }
}
