//Fonction pour insérer les données dans un tableau.
$(function() {
  var type = $("#colonne2").data("type");
  //console.log(type);
  $.get('admin/textsList/' + type , function(o) {
    //Boucle qui lit toutes les données recues de la BDD et qui les insère dans le tableau.
    for (var i = 0; i < o.length; i++) {
      //Création d'une var text qui contient tout le HTML pour créer un ligne.
      //Plus simple que d'écrire d'un trait dans un div.
      var text = '<tr id="tr'+o[i].id+'"><td class="id" scope="row">' + o[i].id +'</td>';
      text += '<td class="type">' + o[i].type + '</td>';
      text += '<td class="title">' + o[i].title + '</td>';

      //Création d'une var extrait pour pouvoir modifier le contenu (nb de caractères à afficher et où couper la fin de l'extrait).
      var extrait = o[i].content.substring(0, 500);
      extrait = extrait.substring(0, extrait.lastIndexOf(">")+1);

      text += '<td class="content" id="contentList">' + extrait + '</td>';
      text += '<td class="date">' + o[i].publication_date + '</td>';
      text += '<td class="deferred_publication">' + o[i].deferred_date + '</td>';
      text += '<td class="edit" data-id ="' + o[i].id + '"><i class="fa fa-pencil fa-lg"></i></td>';
      text += '<td data-toggle="modal" data-target="#modalDelete" data-id ="' + o[i].id + '"><i class="fa fa-times"></i></td></tr>';

      $("#containList").append(text);
    }
    //Nouvelle fonction then() qui permet d'organiser l'ordre d'éxécution des fonctions.
  },'json').then( function() {
    //On insère dans le tableau les éléments de ces classes.
    var options = {
      valueNames : ["id", "type", "title", "content", "date", "deferred_date", "edit", "delete"]
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
  //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
  var line = $('#tr'+id);
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.get("admin/delete/" + id , function(data){
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

});
});

//Evenement au clique de la classe "edit".
$(document).on('click','.edit',function() {
  //On récupère l'id du texte sélectionné.
  var id = $(this).data('id');
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.get("admin/getOne/" + id , function(data){
    //On simule/déclenche un clique sur l'élément "Rédiger" du menu qui ouvre l'éditeur de texte.
    $("#btn_write").trigger("click");
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
          $("#deferred_date").val(data.deferred_date);
          //On récupère le type de l'objet et on l'associe à l'id car ils ont le même "nom".
          //Donc si on récupère un type "chapitre" on clique sur le bouton chapitre.
          //Moins répétitif que de faire ça pour chaque id de chaque boutons différent.
          $("#" + data.type).prop('checked',true);
       }, 1000);
  });
});
});