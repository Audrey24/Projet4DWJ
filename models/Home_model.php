<?php
class Home_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    //Obtenir le dernier article.
    public function getNews()
    {
        //On sélectionne les 5 articles les plus récents.
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date  FROM texts WHERE type = "Article" ORDER BY publication_date  DESC LIMIT 5');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Fonction pour récupèrer une news en fonction de l'id sélectionné.
    public function getOneNews($id)
    {
        $req = $this->db->prepare('SELECT title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date FROM texts WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        return $res;
    }

    public function getComments()
    {
        //On sélectionne les 5 articles les plus récents.
        $req = $this->db->prepare('SELECT content, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date  FROM comments WHERE  ORDER BY published_date  DESC LIMIT 20');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    public function comments()
    {
        $content = $_POST['comment'];

        $req = $this->db->prepare('INSERT INTO comments (content) VALUES(:content)');
        $req->execute(array(
            'content' => $content));
    }
}
