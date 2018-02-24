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
        $req = $this->db->prepare('SELECT title, content FROM chapters WHERE  deferred_date < NOW() ORDER BY publication_date  ASC LIMIT 1');
        $req->execute();

        $res = $req->fetch();
        echo json_encode($res);
    }

    //Obtenir un chapitre en fonction de son id.
    public function getOneChapter($id)
    {
        $req = $this->db->prepare('SELECT id, title, content FROM chapters WHERE id = :id');
        $req->execute(array(
          'id' => $id
        ));

        $res = $req->fetch();
        return $res;
    }

    public function commentChapter()
    {
        //On récupère l'id du texte que l'on commente et les données du commentaire.
        $id_chapter = $_POST['id_chapter'];
        $content = $_POST['content'];
        Session::init();
        $id = Session::get('id');

        //On insère dans le Bdd et on ajoute l'id de l'user pour pouvoir ajouter le pseudo sur la vue.
        $req = $this->db->prepare('INSERT INTO commentschapter (content, id_user, id_chapter) VALUES(:content, :id_user, :id_chapter)');
        $req->execute(array(
            'content' => $content,
            'id_user' => $id,
            'id_chapter' => $id_chapter));
    }

    //Afficher les 20 derniers commentaires.
    public function getCommentsChapter()
    {
        $id_chapter = $_POST['id_chapter'];
        //On sélectionne les 20 commentaires les plus récents.
        $req = $this->db->prepare('SELECT commentschapter.id, commentschapter.content, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date, users.pseudo FROM commentschapter INNER JOIN users ON commentschapter.id_user = users.id WHERE id_chapter = :id_chapter ORDER BY published_date  DESC LIMIT 20');
        $req->execute(array(
            'id_chapter' => $id_chapter));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    public function delete_commentsChapter($id)
    {
        $req = $this->db->prepare('DELETE FROM commentschapter WHERE id = :id');
        $req->execute(array(
        'id' => $id));
        echo($id);
    }

    public function dislikeComment()
    {
        $id = $_POST['id'];
        echo $id;

        $req = $this->db->prepare('UPDATE commentschapter SET dislike = dislike+1 WHERE id= :id');
        $req->execute(array(
        'id' => $id));
    }
}
