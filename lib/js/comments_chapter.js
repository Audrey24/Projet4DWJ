//Evenement sur le clique du bouton "commenter" de la page "Lecture en cours".
$('#commenter_chap').on('click', function() {
  var content = $("#commentChapter").val();
  //console.log(content);

  //Requête pour envoyer au serveur les données contenu, id de l'user et id du texte.
  $.ajax({
    url: url + "Current_chapter/commentChapter",
    type: "POST",
    data : {
      content : content,
      id_user : id,
      id_chapter : $('#flipbook').data('id')
    },
    //Si la requête a aboutit, on insère les données dans le tableau et on affiche un msg pour confirmer l'envoi.
    success: function(data) {
        //On affiche la date au format français.
        var date = new Date();

        var text = '<tr><td class="pseudo_chap">' + pseudo + '</td>';
             text += '<td class="content_chap" scope="row">' + content + '</td>';
             text += '<td class="date_chap">' + date.toLocaleDateString("fr-FR") + '</td></tr>';
        $("#contain_commentsChap").append(text);

        $('#commentChp').html("<div class='alert alert-success'>");
        $('#commentChp > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
        $('#commentChp > .alert-success').append("<strong>" + "Message envoyé" + "</strong>");
        $('#commentChp > .alert-success').append('</div>');
        //On efface les champs/
        $('#commentChapter').val("");
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#commentChp').html("");
        }, 3000);
      },
    //Si la requête échoue, on envoit un msg.
    error: function() {
        $('#commentChp').html("<div class='alert alert-danger'>");
        $('#commentChp > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
        $('#commentChp > .alert-danger').append("<strong>" + "Désolé, votre message n'a pas pu être envoyé !" + "</strong>" );
        $('#commentChp > .alert-danger').append('</div>');
        //On efface les champs/
        $('#commentChapter').val("");
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#commentChp').html("");
        }, 3000);
      },
    });
  });

//Afficher les commentaires.
$(function() {
  //Requête pour envoyer au serveur l'id du texte.
  $.ajax({
    url: url + "Current_chapter/getCommentsChapter",
    type: "POST",
    data : {
      id_chapter : $('#flipbook').data('id')
    },
    //Si la requête a fonctionné, on a récupéré les commentaires et on les insère dans le div.
     success: function(data) {
      //console.log(data);
      data = JSON.parse(data);
      //Boucle qui lit tous les commentaires.
      for (var i = 0; i < data.length; i++) {
      //console.log(data);
        var text = '<tr id="tr' +data[i].id +'"><td class="pseudo_chap">' + data[i].pseudo + '</td>';
        text += '<td class="content_chap" scope="row">' + data[i].content + '</td>';
        text += '<td class="date_chap">' + data[i].published_date + '</td>';
          if ((role == "admin") || (role == "moderateur")) {
            text += '<td class="delete_comChap" data-id ="' + data[i].id + '"><i class="fa fa-times"></i></td></tr>';
          } else if (role == "visiteur" && data[i].id_user == null) {
            text += '<td><button class="btnDislike" data-toggle="modal" data-target="#modalDeleteComChapter" data-id ="' + data[i].id + '"><i class="fa fa-exclamation-triangle"></i></button></td></tr>';
          }
        $("#contain_commentsChap").append(text);
      }
    }
  });
});

//Evenement au clique de la classe "delete_comments".
$(document).on('click','.delete_comChap',function() {
  //On récupère l'id du commentaire sur lequel on a cliqué et on le range dans une var.
  var id = $(this).data('id');
  console.log(id);
  //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
  var line = $('#tr'+id);
  console.log(line);
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.get(
    url+ "Current_chapter/delete_commentsChapter/" + id,
    function(data) {
      //Si succès on supprime la ligne du tableau.
      line.remove();
      //On envoit un msg pour confirmer la suppression.
      $('#dislike_commentchap').html("<div class='alert alert-success'>");
      $('#dislike_commentchap > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
      $('#dislike_commentchap > .alert-success').append("<strong>" + "Le commentaire a bien été supprimé" + "</strong>");
      $('#dislike_commentchap > .alert-success').append('</div>');
      //Délai avant la fin du message.
      setTimeout(function() {
        $('#dislike_commentchap').html("");
      }, 3000);
    });
  });

  //Fonction pour assigner l'id du bouton cliqué dans la modale.
  $('#modalDeleteComChapter').on('show.bs.modal', function (event) {
  //Bouton qui déclenche la modale (icône croix).
  var button = $(event.relatedTarget);
  //Extrait la valeur de data et on le range dans une var.
  var id = button.data('id');
  var modal = $(this);
  //On assigne au bouton "valider" qui a la classe "delete", la valeur de l'id sur lequel on a cliqué via "data-id".
  modal.find('.dislikeComChapter').data( "id", id);
  });


  //Evenement au clique de la classe "delete".
  $(document).on('click','.dislikeComChapter',function() {
    //On récupère l'id mis dans le bouton "valider" et on le range dans une var.
    var id_comment = $(this).data('id');
    //console.log(id);
    //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
    $.ajax({
      url : url + "Current_chapter/dislikeComment/",
      type :"POST",
      data : {
        id_comment : id_comment,
      },
      success: function(data){
      //console.log(data);
      //Si succès on ferme la modale et on supprime la ligne du tableau.
        $('#modalDeleteComChapter').modal("hide");
      //On envoit un msg pour confirmer la suppression.
        $('#dislike_commentchap').html("<div class='alert alert-success'>");
        $('#dislike_commentchap > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        .append("</button>");
        $('#dislike_commentchap > .alert-success')
        .append("<strong>" + "Votre signalement a bien été pris en compte" + "</strong>");
        $('#dislike_commentchap > .alert-success')
        .append('</div>');
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#dislike_commentchap').html("");
        }, 3000);
      }
  });
  });

  $('.closedModalChapter').on('click',function() {
     $('#modalDeleteComChapter').modal('hide');
  });
