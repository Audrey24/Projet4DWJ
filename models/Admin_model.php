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
        $title = $_POST['title'];

        $req = $this->db->prepare('INSERT INTO texts (type, title, content) VALUES(:type, :title, :content)');
        $req->execute(array(
          'type' => $type,
          'title' => $title,
          'content' => $content));
    }


    public function textsList()
    {
        $req = $this->db->prepare('SELECT id, type, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date  FROM texts ORDER BY publication_date  DESC ');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM texts WHERE id = :id');
        $req->execute(array(
        'id' => $id));
    }

    public function getOne($id)
    {
        $req = $this->db->prepare('SELECT id, type, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date  FROM texts WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        echo json_encode($res);
    }
}
