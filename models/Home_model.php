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
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date  FROM news  ORDER BY publication_date  DESC LIMIT 5');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Fonction pour récupèrer une news en fonction de l'id sélectionné.
    public function getOneNews($id)
    {
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date FROM news WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        return $res;
    }

    //Afficher les 20 derniers commentaires.
    public function getComments()
    {
        $id_text = $_POST['id_text'];
        //On sélectionne les 20 commentaires les plus récents.
        $req = $this->db->prepare('SELECT comments.id, comments.content, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date, users.pseudo FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_text = :id_text ORDER BY published_date  DESC LIMIT 20');
        $req->execute(array(
            'id_text' => $id_text));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Commenter.
    public function comments()
    {
        //On récupère l'id du texte que l'on commente et les données du commentaire.
        $id_text = $_POST['id_text'];
        $content = $_POST['content'];
        Session::init();
        $id = Session::get('id');

        //On insère dans le Bdd et on ajoute l'id de l'user pour pouvoir ajouter le pseudo sur la vue.
        $req = $this->db->prepare('INSERT INTO comments (content, id_user, id_text) VALUES(:content, :id_user, :id_text)');
        $req->execute(array(
            'content' => $content,
            'id_user' => $id,
            'id_text' => $id_text));
    }

    //Fonction pour suppression les entrées de la Bdd par rapport à l'id sélectionné.
    public function delete_comments($id)
    {
        $req = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        $req->execute(array(
        'id' => $id));
        echo($id);
    }

    public function dislikeComments()
    {
        $id = $_POST['id'];
        echo $id;

        $req = $this->db->prepare('UPDATE comments SET dislike = dislike+1 WHERE id= :id');
        $req->execute(array(
        'id' => $id));
    }
}
