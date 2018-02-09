
<?php

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('home/index');
    }

    public function other()
    {
        echo "page other";
        require 'models/Home_model.php';
        $model = new Home_model();
    }
}

 ?>
