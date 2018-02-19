<?php
class Current_chapter_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    //Obtenir le dernier chapitre.
    public function getLastChapter()
    {
        //On sélectionne le chapitre sans data de publication différée le plus récent.
        $req = $this->db->prepare('SELECT title, content FROM texts WHERE type = "Chapitre" AND deferred_date < NOW() ORDER BY publication_date  ASC LIMIT 1');
        $req->execute();

        $res = $req->fetch();
        echo json_encode($res);
    }
}
