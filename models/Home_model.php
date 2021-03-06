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
        $req = $this->db->prepare('SELECT id, title, content, deferred_date  FROM news  WHERE  deferred_date < NOW() ORDER BY deferred_date  DESC LIMIT 5');
        $req->execute();

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Fonction pour récupèrer une news en fonction de l'id sélectionné.
    public function getOneNews($id)
    {
        $req = $this->db->prepare('SELECT id, title, content, deferred_date FROM news WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        return $res;
    }

    //Afficher les 20 derniers commentaires.
    public function getComments()
    {
        Session::init();
        $id_text = $_POST['id_text'];
        //On sélectionne les 20 commentaires les plus récents.
        $req = $this->db->prepare('SELECT comments.id, comments.content,
                                          DATE_FORMAT(comments.published_date, "%d/%m/%Y") AS published_date,
                                          users.pseudo, report_news.id_user
                                   FROM comments
                                   INNER JOIN users ON comments.id_user = users.id
                                   LEFT JOIN report_news ON report_news.id_user = :session
                                   AND report_news.id_comment = comments.id
                                   WHERE comments.id_text = :id_text
                                   ORDER BY comments.published_date
                                   DESC LIMIT 20');
        $req->execute(array(
            'id_text' => $id_text,
             'session' => Session::get('id')
           ));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Commenter.
    public function comments()
    {
        //On récupère l'id du texte que l'on commente et les données du commentaire.
        $id_text = $_POST['id_text'];
        $content = $_POST['content'];
        $content = htmlspecialchars($content);
        Session::init();
        $id = Session::get('id');

        if (!empty($content)) {
            //On insère dans le Bdd et on ajoute l'id de l'user pour pouvoir ajouter le pseudo sur la vue.
            $req = $this->db->prepare('INSERT INTO comments (content, id_user, id_text) VALUES(:content, :id_user, :id_text)');
            $req->execute(array(
            'content' => $content,
            'id_user' => $id,
            'id_text' => $id_text));
        };
    }

    //Fonction pour suppression les entrées de la Bdd par rapport à l'id sélectionné.
    public function delete_comments($id)
    {
        $req = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        $req->execute(array(
        'id' => $id));

        $req = $this->db->prepare('DELETE FROM report_news WHERE id_comment = :id_comment');
        $req->execute(array(
        'id_comment' => $id));
    }

    public function dislikeComments()
    {
        $id_comment = $_POST['id_comment'];
        $id_text = $_POST['id_text'];
        Session::init();
        $id_user = Session::get('id');
        echo $id_text;


        $req = $this->db->prepare('INSERT INTO report_news (id_user, id_comment, id_text) VALUES(:id_user, :id_comment, :id_text)');
        $req->execute(array(
        'id_user' => $id_user,
        'id_comment' => $id_comment,
        'id_text' => $id_text));
    }
}
