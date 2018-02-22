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
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date FROM texts WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        return $res;
    }

    public function getComments()
    {
        $id_text = $_POST['id_text'];
        //On sélectionne les 20 commentaires les plus récents.
        $req = $this->db->prepare('SELECT comments.content, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date, users.pseudo FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_text = :id_text ORDER BY published_date  DESC LIMIT 20');
        $req->execute(array(
            'id_text' => $id_text));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    public function comments()
    {
        $id_text = $_POST['id_text'];
        $content = $_POST['content'];
        Session::init();
        $id = Session::get('id');

        $req = $this->db->prepare('INSERT INTO comments (content, id_user, id_text) VALUES(:content, :id_user, :id_text)');
        $req->execute(array(
            'content' => $content,
            'id_user' => $id,
            'id_text' => $id_text));

    }
}
