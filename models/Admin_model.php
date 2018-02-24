<?php
class Admin_model extends Model
{
    //Construction sur le model du parent qui est Model.
    public function __construct()
    {
        parent::__construct();
    }

    //Création d'un texte et envoit en Bdd.
    public function create()
    {
        //Déclaration des var
        $content = $_POST['editor'];
        $type = $_POST['typeTexte'];
        $title = $_POST['title'];
        //Si la publication différée est vide, on lui assigne la date actuelle.
        if (!isset($_POST['deferred_date']) || (empty($_POST['deferred_date']))) {
            $deferred_date = date('Y-m-d');
        } else {
            //Sinon, on récupère celle définit et on lui change son format pour qu'il corresponde à celui de php et de la Bdd.
            $deferred_date = date('Y-m-d', strtotime($_POST['deferred_date']));
        }

        //Si l'id est déjà saisi, on le récupère dans une var (le texte est donc déjà existant)
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            //Et on effectue une mise à jour du texte.
            switch ($type) {
              case 'Article':
                $this->updateNews($id, $title, $content, $deferred_date);
                break;

              case 'Chapitre':
                $this->updateChapters($id, $title, $content, $deferred_date);
                break;

              case 'Brouillon':
                $this->updateDrafts($id, $title, $content, $deferred_date);
                break;

              default:
                echo "Erreur";
                break;
            }
        } else {
            //Sinon cela veut dire que c'est un nouveau texte et donc on l'insère dans la Bdd.
            switch ($type) {
              case 'Article':
                $this->insertNews($title, $content, $deferred_date);
                break;

              case 'Chapitre':
                $this->insertChapters($title, $content, $deferred_date);
                break;

              case 'Brouillon':
                $this->insertDrafts($title, $content, $deferred_date);
                break;

              default:
                echo "Erreur";
                break;
            }
        }
    }

    //Fonction qui récupère les textes de la bdd.
    public function textsList($type)
    {
        switch ($type) {
        case 'Article':
          $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date FROM news ORDER BY publication_date  DESC ');
          $req->execute(array(
            "type" => $type));

          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        case 'Chapitre':
          $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date FROM chapters ORDER BY publication_date  DESC ');
          $req->execute(array(
            "type" => $type));

          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        case 'Brouillon':
          $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date FROM drafts ORDER BY publication_date  DESC ');
          $req->execute(array(
            "type" => $type));

            $res = $req->fetchAll();
            echo json_encode($res);
        break;

        default:
          echo "Erreur, pas de textes";
        break;
      }
    }

    //Fonction pour suppression les entrées de la Bdd par rapport à l'id sélectionné.
    public function delete()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];

        switch ($type) {
      case 'Article':
        $req = $this->db->prepare('DELETE FROM news WHERE id = :id');
        $req->execute(array(
          'id' => $id));
      break;

      case 'Chapitre':
        $req = $this->db->prepare('DELETE FROM chapters WHERE id = :id');
        $req->execute(array(
          'id' => $id));
      break;

      case 'Brouillon':
        $req = $this->db->prepare('DELETE FROM drafts WHERE id = :id');
        $req->execute(array(
          'id' => $id));
      break;

      default:
        echo "Erreur, pas de textes";
      break;
    }
    }

    //Fonction pour récupèrer un texte en fonction de l'id sélectionné.
    public function getOne()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];

        switch ($type) {
      case 'Article':
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date  FROM news WHERE id = :id ');
        $req->execute(array(
          'id' => $id));
        $res = $req->fetch();
        echo json_encode($res);

      break;

      case 'Chapitre':
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date  FROM chapters WHERE id = :id ');
        $req->execute(array(
          'id' => $id));
        $res = $req->fetch();
        echo json_encode($res);

      break;

      case 'Brouillon':
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date  FROM drafts WHERE id = :id ');
        $req->execute(array(
          'id' => $id));
        $res = $req->fetch();
        echo json_encode($res);

      break;

      default:
        echo "Erreur, pas de textes";
      break;
    }
    }

    //Fonctions qui mettent à jour les textes.
    public function updateNews($id, $title, $content, $deferred_date)
    {
        $req = $this->db->prepare('UPDATE news SET  title = :title, content = :content, deferred_date = :deferred_date WHERE id= :id');
        $req->execute(array(
          'id' => $id,
          'title' => $title,
          'content' => $content,
          'deferred_date' => $deferred_date));
    }

    public function updateChapters($id, $title, $content, $deferred_date)
    {
        $req = $this->db->prepare('UPDATE chapters SET  title = :title, content = :content, deferred_date = :deferred_date WHERE id= :id');
        $req->execute(array(
          'id' => $id,
          'title' => $title,
          'content' => $content,
          'deferred_date' =>$deferred_date));
    }

    public function updateDrafts($id, $title, $content, $deferred_date)
    {
        $req = $this->db->prepare('UPDATE drafts SET  title = :title, content = :content, deferred_date = :deferred_date WHERE id= :id');
        $req->execute(array(
          'id' => $id,
          'title' => $title,
          'content' => $content,
          'deferred_date' =>$deferred_date));
    }

    //Fonctions qui insèrent les textes en BDD.
    public function insertNews($title, $content, $deferred_date)
    {
        $req = $this->db->prepare('INSERT INTO news (title, content, deferred_date) VALUES(:title, :content, :deferred_date)');
        $req->execute(array(
          'title' => $title,
          'content' => $content,
          'deferred_date' =>$deferred_date));
    }

    public function insertChapters($title, $content, $deferred_date)
    {
        $req = $this->db->prepare('INSERT INTO chapters (title, content, deferred_date) VALUES(:title, :content, :deferred_date)');
        $req->execute(array(
        'title' => $title,
        'content' => $content,
        'deferred_date' =>$deferred_date));
    }

    public function insertDrafts($title, $content, $deferred_date)
    {
        $req = $this->db->prepare('INSERT INTO drafts (title, content, deferred_date) VALUES(:title, :content, :deferred_date)');
        $req->execute(array(
          'title' => $title,
          'content' => $content,
          'deferred_date' =>$deferred_date));
    }

    public function getDislike($type)
    {
        switch ($type) {
        case 'Article':
        $req = $this->db->prepare('SELECT comments.id, comments.content, users.pseudo, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date FROM comments INNER JOIN users ON comments.id_user = users.id WHERE dislike > 3');
        $req->execute();
        $res = $req->fetchAll();
        echo json_encode($res);

        break;

          case 'Chapitre':
          $req = $this->db->prepare('SELECT commentschapter.id, commentschapter.content, users.pseudo, DATE_FORMAT( published_date, "%d/%m/%Y") AS published_date FROM commentschapter INNER JOIN users ON commentschapter.id_user = users.id WHERE dislike > 3');
          $req->execute();
          $res = $req->fetchAll();
          echo json_encode($res);
          break;
        }
    }

    public function deleteComments()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];

        switch ($type) {
      case 'Article':
        $req = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        $req->execute(array(
          'id' => $id));
      break;

      case 'Chapitre':
        $req = $this->db->prepare('DELETE FROM commentschapter WHERE id = :id');
        $req->execute(array(
          'id' => $id));
      break;
    }
    }
}
