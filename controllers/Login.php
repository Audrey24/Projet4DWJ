
<?php

class Login extends Controller
{
    //Construction sur le model du parent qui est Controller.
    public function __construct()
    {
        parent::__construct();
    }

    //Fonctions qui appellent les fonctions définies dans le model.

    public function signin()
    {
        $this->model->signin();
    }

    public function signup()
    {
        $this->model->signup();
    }

    public function disconnect()
    {
        $this->model->disconnect();
    }
}

 ?>
