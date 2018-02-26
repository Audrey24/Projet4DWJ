//Evenement sur le clique du bouton "commenter".
$('#commenter').on('click', function() {
  var content = $("#comment").val();
  //console.log(content);

  //Requête pour envoyer au serveur les données contenu, id de l'user et id du texte.
  $.ajax({
    url: url + "Home/comments",
    type: "POST",
    data : {
      content : content,
      id_user : id,
      id_text : $('#newspage').data('id')
    },
    //Si la requête a aboutit, on insère les données dans le tableau et on affiche un msg pour confirmer l'envoi.
    success: function(data) {
        //On affiche la date au format français.
        var date = new Date();

        var text = '<tr><td class="pseudo_comments">' + pseudo + '</td>';
             text += '<td class="content_comments" scope="row">' + content + '</td>';
             text += '<td class="date_comments">' + date.toLocaleDateString("fr-FR") + '</td></tr>';
        $("#contain_comments").append(text);

        $('#commentMsg').html("<div class='alert alert-success'>");
        $('#commentMsg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
        $('#commentMsg > .alert-success').append("<strong>" + "Message envoyé" + "</strong>");
        $('#commentMsg > .alert-success').append('</div>');
        //On efface les champs/
        $('#comment').val("");
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#commentMsg').html("");
        }, 3000);
      },
    //Si la requête échoue, on envoit un msg.
    error: function() {
        $('#commentMsg').html("<div class='alert alert-danger'>");
        $('#commentMsg > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
        $('#commentMsg > .alert-danger').append("<strong>" + "Désolé, votre message n'a pas pu être envoyé !" + "</strong>" );
        $('#commentMsg > .alert-danger').append('</div>');
        //On efface les champs/
        $('#comment').val("");
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#commentMsg').html("");
        }, 3000);
      },
    });
  });

//Afficher les commentaires.
$(function() {
  //Requête pour envoyer au serveur l'id du texte.
  $.ajax({
    url: url + "Home/getComments",
    type: "POST",
    data : {
      id_text : $('#newspage').data('id')
    },
    //Si la requête a fonctionné, on a récupéré les commentaires et on les insère dans le div.
     success: function(data) {
      //console.log(data);
      data = JSON.parse(data);
      //Boucle qui lit tous les commentaires.
      for (var i = 0; i < data.length; i++) {
      //console.log(data);
        var text = '<tr id="tr' +data[i].id +'"><td class="pseudo_comments">' + data[i].pseudo + '</td>';
        text += '<td class="content_comments" scope="row">' + data[i].content + '</td>';
        text += '<td class="date_comments">' + data[i].published_date + '</td>';
          if ((role == "admin") || (role == "moderateur")) {
            text += '<td class="delete_comments" data-id ="' + data[i].id + '"><i class="fa fa-times"></i></td></tr>';
          } else if (role == "visiteur") {
            text += '<td><button class="dislike' + data[i].id +'" data-toggle="modal" data-target="#modalComments" data-id ="' + data[i].id + '"><i class="fa fa-exclamation-triangle"></i></button></td></tr>';
          }
        $("#contain_comments").append(text);
      }
    }
  });
});

//Evenement au clique de la classe "delete_comments".
$(document).on('click','.delete_comments',function() {
  //On récupère l'id du commentaire sur lequel on a cliqué et on le range dans une var.
  var id = $(this).data('id');
  console.log(id);
  //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
  var line = $('#tr'+id);
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.get(
    url+ "home/delete_comments/" + id,
    function(data) {
      //Si succès on supprime la ligne du tableau.
      line.remove();
      //On envoit un msg pour confirmer la suppression.
      $('#del_comment').html("<div class='alert alert-success'>");
      $('#del_comment > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
      $('#del_comment > .alert-success').append("<strong>" + "Le commentaire a bien été supprimé" + "</strong>");
      $('#del_comment > .alert-success').append('</div>');
      //Délai avant la fin du message.
      setTimeout(function() {
        $('#del_comment').html("");
      }, 3000);
    });
  });

  //Fonction pour assigner l'id du bouton cliqué dans la modale.
  $('#modalComments').on('show.bs.modal', function (event) {
  //Bouton qui déclenche la modale (icône croix).
  var button = $(event.relatedTarget);
  //Extrait la valeur de data et on le range dans une var.
  var id = button.data('id');
  var modal = $(this);
  //On assigne au bouton "valider" qui a la classe "delete", la valeur de l'id sur lequel on a cliqué via "data-id".
  modal.find('.dislikeComments').data( "id", id);
  });

  //Evenement au clique de la classe "delete".
  $(document).on('click','.dislikeComments',function() {
    //On récupère l'id mis dans le bouton "valider" et on le range dans une var.
    var id_comment = $(this).data('id');
    //console.log(id);
    //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
    $.ajax({
      url : url + "Home/dislikeComments",
      type :"POST",
      data : {
        id_comment : id_comment,
      },
      success: function(data){
      //console.log(data);
      //Si succès on ferme la modale et on supprime la ligne du tableau.
        $('#modalComments').modal("hide");
      //On envoit un msg pour confirmer la suppression.
        $('#del_comment').html("<div class='alert alert-success'>");
        $('#del_comment > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        .append("</button>");
        $('#del_comment > .alert-success')
        .append("<strong>" + "Votre signalement a bien été pris en compte" + "</strong>");
        $('#del_comment > .alert-success')
        .append('</div>');
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#del_comment').html("");
        }, 3000);
      }
  });
  });

  $('.closedModalComments').on('click',function() {
     $('#modalComments').modal('hide');
  });
