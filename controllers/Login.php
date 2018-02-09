
<?php

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //$this->view->render('login/connexionform');
    }

    public function signin()
    {
        $this->model->signin();
    }

    public function signup()
    {
        $this->model->signup();
    }
}

 ?>
