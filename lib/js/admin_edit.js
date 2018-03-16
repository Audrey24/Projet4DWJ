//Fonction pour insérer les données dans un tableau.
$(function() {
  var type = $("#colonne2").data("type");
  //console.log(type);
  $.ajax({
    url :'admin/textsList/' + type ,
    type :'GET',
    async:true,
    success : function(o) {
      //console.log(o);
      o = JSON.parse(o);
    //Boucle qui lit toutes les données recues de la BDD et qui les insère dans le tableau.
      for (var i = 0; i < o.length; i++) {
        //Création d'une var text qui contient tout le HTML pour créer un ligne.
        //Plus simple que d'écrire d'un trait dans un div.
        var text = '<tr id="tr'+o[i].id+'"><td class="id" scope="row">' + o[i].id +'</td>';
        text += '<td class="title">' + o[i].title + '</td>';

        //Création d'une var extrait pour pouvoir modifier le contenu (nb de caractères à afficher et où couper la fin de l'extrait).
        var extrait = o[i].content.substring(0, 500);
        extrait = extrait.substring(0, extrait.lastIndexOf(">")+1);

        //Création de var pour pouvoir modifier le format reçu de la bdd.
        var publiee = new Date(o[i].publication_date);
        var differee = new Date(o[i].deferred_date);

        text += '<td class="content" id="contentList">' + extrait + '</td>';
        text += '<td class="date">' + publiee.toLocaleDateString("fr-FR") + '</td>';
        text += '<td class="deferred_publication">' + differee.toLocaleDateString("fr-FR") + '</td>';
        text += '<td class="edit" data-id ="' + o[i].id + '"><i class="fa fa-pencil fa-lg"></i></td>';
        text += '<td class="delete_icone" data-toggle="modal" data-target="#modalDelete" data-id ="' + o[i].id + '"><i class="fa fa-times"></i></td></tr>';

        $("#containList").append(text);
      }
    //Nouvelle fonction then() qui permet d'organiser l'ordre d'éxécution des fonctions.
  }
  }).then( function() {
    //On insère dans le tableau les éléments de ces classes.
    var options = {
      valueNames : ["id", "title", "content", "date", "deferred_date", "edit", "delete"]
    };
    var typeList = new List("tableau", options);
  });

  //Fonction pour assigner l'id du bouton cliqué dans la modale.
  $('#modalDelete').on('show.bs.modal', function (event) {
  //Bouton qui déclenche la modale (icône croix).
  var button = $(event.relatedTarget);
  //Extrait la valeur de data et on le range dans une var.
  var id = button.data('id');
  var modal = $(this);
  //On assigne au bouton "valider" qui a la classe "delete", la valeur de l'id sur lequel on a cliqué via "data-id".
  modal.find('.delete').data( "id", id);
});

//Evenement au clique de la classe "delete".
$(document).on('click','.delete',function() {
  //On récupère l'id mis dans le bouton "valider" et on le range dans une var.
  var id = $(this).data('id');
  var type = $("#colonne2").data("type");
  //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
  var line = $('#tr'+id);
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.ajax({
    async: true,
    url : url+"admin/deleteAJAX/",
    type :"POST",
    data : {
      id : id,
      type : type
    },
    success: function(data){
      //console.log(data);
    //Si succès on ferme la modale et on supprime la ligne du tableau.
      $('#modalDelete').modal("hide");
      line.remove();
    //On envoit un msg pour confirmer la suppression.
      $('#deletemsg').html("<div class='alert alert-success'>");
      $('#deletemsg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
      .append("</button>");
      $('#deletemsg > .alert-success')
      .append("<strong>" + "Le fichier a bien été supprimé" + "</strong>");
      $('#deletemsg > .alert-success')
      .append('</div>');
      //Délai avant la fin du message.
      setTimeout(function() {
        $('#deletemsg').html("");
      }, 3000);
    }
});
});

//Evenement au clique de la classe "edit".
$(document).on('click','.edit',function() {
  console.log("edit");
  //On récupère l'id du texte sélectionné.
  var id = $(this).data('id');
  var type = $("#colonne2").data("type");
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.ajax({
    async: true,
    url : "admin/getOne/",
    type : "POST",
    data : {
    id : id,
    type : type
    },
    success : function(data) {
    //On simule/déclenche un clique sur l'élément "Rédiger" du menu qui ouvre l'éditeur de texte.
    $("#btn_write").trigger("click");
    console.log("clique faux");
        //On indique un délais avant l'éxécution pour avoir le temps de récupérer les données avant de les afficher.
        setTimeout(function() {
          //Les données recues du serveur sont un string donc on les "parse" pour les transformer en objet JS et on les insère dans "data".
          data = JSON.parse(data);
          //Fonction spéciale pour remplir les champs de tinymce avec les données récupérées en JS.
          var tiny = tinymce.get('editor');
          tiny.setContent(data.content);
          //On remplit les champs avec les valeurs récupérées dans l'objet JS.
          $("#title").val(data.title);
          $("#id").val(data.id);
          $("#type").val(type);
          $("#deferred_date").val(data.deferred_date);
          //On récupère le type de l'objet et on l'associe à l'id car ils ont le même "nom".
          //Donc si on récupère un type "chapitre" on clique sur le bouton chapitre.
          //Moins répétitif que de faire ça pour chaque id de chaque boutons différent.
          $("#" + type).prop('checked',true);
       }, 2000);
     }
     });
  });
});

$('.closedModal').on('click',function() {
   $('#modalDelete').modal('hide');
});
