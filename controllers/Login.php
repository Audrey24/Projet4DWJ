
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

    //Fonction pour récupérer son Mdp
    public function recovery($hash)
    {
        $id_user = $this->model->recovery($hash);
        $this->view->addData($id_user);

        if (!empty($id_user)) {
            $this->view->render('login/forgetLogin', 'lib/images/ecrivain.jpeg');
        } else {
            header('location:'. URL . 'home');
        }
    }

    public function generateLog()
    {
        $this->model->generateLog();
    }

    public function updateLog()
    {
        $this->model->updateLog();
    }
}

 ?>
