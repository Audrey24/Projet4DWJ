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

    //Fonction sur les boutons de lecture des chapitres.
    public function next()
    {
        $id= $_POST['id'];
        //On récupère tous les chap dont l'id est supérieur au chap actuel.
        //(plus efficace que de faire +1 - évite les pb quand les chap sont supprimés et que le id ne suivent donc pas )
        $req = $this->db->prepare('SELECT id FROM chapters WHERE id > :id ORDER BY id ASC LIMIT 1');
        $req->execute(array('id' => $id));

        $res = $req->fetch();
        echo $res['id'];
    }

    public function prev()
    {
        $id= $_POST['id'];

        //On récupère tous les chap dont l'id est inférieur au chap actuel.
        $req = $this->db->prepare('SELECT id FROM chapters WHERE id < :id ORDER BY id DESC LIMIT 1');
        $req->execute(array('id' => $id));

        $res = $req->fetch();
        echo $res['id'];
    }

    public function commentChapter()
    {
        //On récupère l'id du texte que l'on commente et les données du commentaire.
        $id_chapter = $_POST['id_chapter'];
        $content = $_POST['content'];
        Session::init();
        $id = Session::get('id');
        echo $id;
        echo $id_chapter;
        echo $content;

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
        Session::init();
        $id_chapter = $_POST['id_chapter'];
        //On sélectionne les 20 commentaires les plus récents.
        $req = $this->db->prepare('SELECT commentschapter.id, commentschapter.content,
                                          DATE_FORMAT(commentschapter.published_date, "%d/%m/%Y") AS published_date,
                                          users.pseudo, report_chapters.id_user
                                   FROM commentschapter
                                   INNER JOIN users ON commentschapter.id_user = users.id
                                   LEFT JOIN report_chapters ON report_chapters.id_user = :session
                                   AND report_chapters.id_comment = commentschapter.id
                                   WHERE id_chapter = :id_chapter
                                   ORDER BY commentschapter.published_date
                                   DESC LIMIT 20');
        $req->execute(array(
            'id_chapter' => $id_chapter,
            'session' => Session::get('id')
          ));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    public function delete_commentsChapter($id)
    {
        $req = $this->db->prepare('DELETE FROM commentschapter WHERE id = :id');
        $req->execute(array(
        'id' => $id));

        $req = $this->db->prepare('DELETE FROM report_chapters WHERE id_comment = :id_comment');
        $req->execute(array(
        'id_comment' => $id));
    }

    public function dislikeComment()
    {
        $id_comment = $_POST['id_comment'];
        Session::init();
        $id_user = Session::get('id');
        echo $id;

        $req = $this->db->prepare('INSERT INTO report_chapters (id_user, id_comment) VALUES(:id_user, :id_comment)');
        $req->execute(array(
        'id_user' => $id_user,
        'id_comment' => $id_comment));
    }

    public function updateCurrent_chapter()
    {
        Session::init();
        $id = Session::get('id');
        $read_chapter = $_POST['id'];
        $read_page = $_POST['read_page'];
        Session::set('read_chapter', $read_chapter);
        Session::set('read_page', $read_page);

        $req = $this->db->prepare('UPDATE users SET read_chapter = :read_chapter, read_page = :read_page WHERE id= :id');
        $req->execute(array(
        'id' => $id,
        'read_chapter' => $read_chapter,
        'read_page' => $read_page
        ));
    }
}
