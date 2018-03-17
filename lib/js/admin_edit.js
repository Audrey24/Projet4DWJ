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
});

$('.closedModal').on('click',function() {
   $('#modalDelete').modal('hide');
});
