<?php
class Admin_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create()
    {
        $content = $_POST['editor'];
        $type = $_POST['typeTexte'];

        $req = $this->db->prepare('INSERT INTO texts (type, content) VALUES(:type, :content)');
        $req->execute(array(
          'type' => $type,
          'content' => $content));
    }
  

    /*public function edit()
    {
    }

    public function delete()
    {
    }*/
}
