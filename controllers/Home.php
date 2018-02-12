<?php

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('home/index', 'lib/images/plume.jpg');
    }

    public function other()
    {
        echo "page other";
        require_once 'models/Home_model.php';
        $model = new Home_model();
    }
}
