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
            $req = $this->db->prepare('UPDATE texts SET type = :type, title = :title, content = :content, deferred_date = :deferred_date WHERE id= :id');
            $req->execute(array(
            'id' => $id,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'deferred_date' =>$deferred_date));
        } else {
            //Sinon cela veut dire que c'est un nouveau texte et donc on l'insère dans la Bdd.
            $req = $this->db->prepare('INSERT INTO texts (type, title, content, deferred_date) VALUES(:type, :title, :content, :deferred_date)');
            $req->execute(array(
                  'type' => $type,
                  'title' => $title,
                  'content' => $content,
                  'deferred_date' =>$deferred_date));
        }
    }

    //Fonction qui récupère les textes de la bdd.
    public function textsList($type)
    {
        $req = $this->db->prepare('SELECT id, type, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date FROM texts WHERE type = :type ORDER BY publication_date  DESC ');
        $req->execute(array(
          "type" => $type));

        $res = $req->fetchAll();
        echo json_encode($res);
    }

    //Fonction pour suppression les entrées de la Bdd par rapport à l'id sélectionné.
    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM texts WHERE id = :id');
        $req->execute(array(
        'id' => $id));
    }

    //Fonction pour récupèrer un texte en fonction de l'id sélectionné.
    public function getOne($id)
    {
        $req = $this->db->prepare('SELECT id, type, title, content, DATE_FORMAT( publication_date, "%d/%m/%Y") AS publication_date, DATE_FORMAT( deferred_date, "%d/%m/%Y") AS deferred_date  FROM texts WHERE id = :id ');
        $req->execute(array(
        'id' => $id));

        $res = $req->fetch();
        echo json_encode($res);
    }
}
