<?php
class Teaser_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    public function extractChapter()
    {
        $req = $this->db->prepare('SELECT id, title, content FROM chapters WHERE  deferred_date < NOW() ORDER BY publication_date  ASC LIMIT 1');
        $req->execute();

        $res = $req->fetch();
        return $res;
    }
}
