<?php
class Last_chapters_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    //Obtenir les chapitres.
    public function getChapters()
    {
        $req = $this->db->prepare('SELECT id, title, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date FROM chapters ORDER BY id DESC');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }
}
