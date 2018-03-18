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
        $oldtype = $_POST['type'];
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
            //Et on vérifie les changements.
            switch ($type) {
              case 'Article':
              //Si pas de changement de type de texte, on fait une MAJ.
                if ($type == $oldtype) {
                    $this->updateNews($id, $title, $content, $deferred_date);
                } else {
                    //Si changement, on supprime l'ancien texte de sa table de bdd.
                    $this->delete($id, $oldtype);
                    //Et on l'innsère dans le table du nouveau type.
                    $this->insert($type, $title, $content, $deferred_date);
                }
              break;

              case 'Chapitre':
              if ($type == $oldtype) {
                  $this->updateChapters($id, $title, $content, $deferred_date);
              } else {
                  $this->delete($id, $oldtype);
                  $this->insert($type, $title, $content, $deferred_date);
              }
             break;

              case 'Brouillon':
              if ($type == $oldtype) {
                  $this->updateDrafts($id, $title, $content, $deferred_date);
              } else {
                  $this->delete($id, $oldtype);
                  $this->insert($type, $title, $content, $deferred_date);
              }
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
          $req = $this->db->prepare('SELECT id, title, content, publication_date, deferred_date FROM news ORDER BY deferred_date  DESC ');
          $req->execute(array(
            "type" => $type));

          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        case 'Chapitre':
          $req = $this->db->prepare('SELECT id, title, content, publication_date, deferred_date FROM chapters ORDER BY deferred_date  DESC ');
          $req->execute(array(
            "type" => $type));

          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        case 'Brouillon':
          $req = $this->db->prepare('SELECT id, title, content,  publication_date,  deferred_date FROM drafts ORDER BY deferred_date  DESC ');
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
    //Obligé de faire deux requêtes plutôt qu'une jointure car impossible avec la jointure de supprimer
    //un chapitre sans commentaire. Il fallait absolument qu'il est lien entre les 2 tables.
    public function delete($id, $type)
    {
        switch ($type) {
        case 'Article':
          $req = $this->db->prepare('DELETE FROM news WHERE id = :id');
          $req->execute(array(
            'id' => $id));

          $req = $this->db->prepare(' DELETE FROM comments WHERE id_text = :id');
          $req->execute(array(
            'id' => $id));

          $req = $this->db->prepare(' DELETE FROM report_news WHERE id_text = :id');
          $req->execute(array(
            'id' => $id));
        break;

        case 'Chapitre':
          $req = $this->db->prepare('DELETE  FROM chapters WHERE id = :id');
          $req->execute(array(
           'id' => $id));

          $req = $this->db->prepare(' DELETE FROM commentschapter WHERE id_chapter = :id');
          $req->execute(array(
            'id' => $id));

          $req = $this->db->prepare(' DELETE FROM report_chapters WHERE id_text = :id');
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

    public function deleteAJAX()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $this->delete($id, $type);
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

    public function insert($type, $title, $content, $deferred_date)
    {
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
            echo "Erreur, pas de textes";
        break;
      }
    }

    public function getDislike($type)
    {
        switch ($type) {
        case 'Article':
        $req = $this->db->prepare('SELECT report_news.id_comment, COUNT(*) AS count, comments.id, comments.content, DATE_FORMAT(comments.published_date, "%d/%m/%Y") AS published_date, comments.id_user, T.pseudo
                                    FROM report_news
                                    INNER JOIN comments ON report_news.id_comment = comments.id
                                    INNER JOIN (
                                      SELECT users.pseudo AS pseudo, users.id FROM users INNER JOIN comments
                                      ON users.id = comments.id_user ) AS T
                                    ON comments.id_user = T.id
                                    GROUP BY id_comment
                                    HAVING COUNT(*) >= 1');
        $req->execute();
        $res = $req->fetchAll();
        echo json_encode($res);

        break;

          case 'Chapitre':
          $req = $this->db->prepare('SELECT report_chapters.id_comment, COUNT(*) AS count, commentschapter.id, commentschapter.content, DATE_FORMAT(commentschapter.published_date, "%d/%m/%Y") AS published_date, commentschapter.id_user, K.pseudo
                                      FROM report_chapters
                                      INNER JOIN commentschapter ON report_chapters.id_comment = commentschapter.id
                                      INNER JOIN (
                                        SELECT users.pseudo AS pseudo, users.id FROM users INNER JOIN commentschapter
                                        ON users.id = commentschapter.id_user ) AS K
                                      ON commentschapter.id_user = K.id
                                      GROUP BY id_comment
                                      HAVING COUNT(*) >= 1');

          $req->execute();
          $res = $req->fetchAll();
          echo json_encode($res);
          break;
        }
    }

    public function getComments($type)
    {
        switch ($type) {
        case 'Article':
          $req = $this->db->prepare('SELECT comments.id, comments.content,
                                      DATE_FORMAT(comments.published_date, "%d/%m/%Y") AS published_date,
                                      users.pseudo
                                    FROM comments
                                    INNER JOIN users ON comments.id_user = users.id
                                    ORDER BY comments.published_date
                                    DESC LIMIT 20');

          $req->execute();
          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        case 'Chapitre':
          $req = $this->db->prepare('SELECT commentschapter.id, commentschapter.content,
                                      DATE_FORMAT( commentschapter.published_date, "%d/%m/%Y") AS published_date,
                                      users.pseudo
                                     FROM commentschapter
                                     INNER JOIN users ON commentschapter.id_user = users.id
                                     ORDER BY commentschapter.published_date
                                     DESC LIMIT 20');
          $req->execute();
          $res = $req->fetchAll();
          echo json_encode($res);
        break;

        default:
          echo "Erreur, pas de textes";
          break;
        }
    }

    public function deleteComments()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        echo($id);

        switch ($type) {
      case 'Article':
        $req = $this->db->prepare('DELETE FROM comments WHERE comments.id = :id');
        $req->execute(array(
          'id' => $id));

        $req = $this->db->prepare('DELETE  FROM report_news WHERE report_news.id_comment = :id');
        $req->execute(array(
          'id' => $id));
      break;

      case 'Chapitre':
        $req = $this->db->prepare('DELETE FROM commentschapter WHERE commentschapter.id = :id');
        $req->execute(array(
          'id' => $id));

          $req = $this->db->prepare('DELETE  FROM report_chapters WHERE report_chapters.id_comment = :id');
          $req->execute(array(
           'id' => $id));
      break;
      }
    }

    public function validComments()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        echo($id);

        switch ($type) {
          case 'Article':
          $req = $this->db->prepare('DELETE FROM report_news WHERE id_comment = :id_comment');
          $req->execute(array(
            'id_comment' => $id));

          break;

          case 'Chapitre':
          $req = $this->db->prepare('DELETE FROM report_chapters WHERE id_comment = :id_comment');
          $req->execute(array(
            'id_comment' => $id));
          break;
        }
    }

    public function editType()
    {
        switch ($type) {
      case 'Article':
        $req = $this->db->prepare('DELETE FROM nWHERE comments.id = :id');
        $req->execute(array(
          'id' => $id));

    $req = $this->db->prepare('DELETE  FROM report_news WHERE report_news.id_comment = :id');
    $req->execute(array(
      'id' => $id));
  break;

  case 'Chapitre':
    $req = $this->db->prepare('DELETE FROM commentschapter WHERE commentschapter.id = :id');
    $req->execute(array(
      'id' => $id));

      $req = $this->db->prepare('DELETE  FROM report_chapters WHERE report_chapters.id_comment = :id');
      $req->execute(array(
       'id' => $id));
  break;
  }
    }
}
