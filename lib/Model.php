<?php
class Model
{
    //Tous les models auront l'attr 'db' définit et donc accessible.
    public function __construct()
    {
        $this->db= new Database();
    }
}
