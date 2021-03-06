//Fonction pour insérer les données dans un tableau.
$(function() {
  var type = $("#colonne2").data("type");
  //console.log(type);
  $.ajax({
    async: true,
    url : 'admin/getComments/' + type,
    type : 'GET',
    success : function(o) {
    o = JSON.parse(o);
    //Boucle qui lit toutes les données recues de la BDD et qui les insère dans le tableau.
    for (var i = 0; i < o.length; i++) {
      //Plus simple que d'écrire d'un trait dans un div.
      text = '<tr id="tr'+o[i].id+'"><td class="pseudoComments">' + o[i].pseudo + '</td>';
      text += '<td>' + o[i].content + '</td>';
      text += '<td class="dateComments">' + o[i].published_date + '</td>';
      text += '<td class="delete" data-id ="' + o[i].id + '"><i class="fa fa-times"></i></td></tr>';

      $("#tablelastComments").append(text);
    }
  }
});
});

  //Evenement au clique de la classe "deleteDislike".
  $(document).on('click','.delete', function() {
    //On récupère l'id.
    var id = $(this).data('id');
    //console.log(id);
    var type = $("#colonne2").data("type");
    //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
    var line = $('#tr'+id);
    //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
    $.ajax({
      async: true,
      url : "admin/deleteComments/",
      type :"POST",
      data : {
        id : id,
        type : type
      },
      success: function(data){
        //console.log(data);
      //Si succès on ferme la modale et on supprime la ligne du tableau.
        line.remove();
      //On envoit un msg pour confirmer la suppression.
        $('#msglastComments').html("<div class='alert alert-success'>");
        $('#msglastComments > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        .append("</button>");
        $('#msglastComments > .alert-success')
        .append("<strong>" + "Le commentaire a bien été supprimé" + "</strong>");
        $('#msglastComments > .alert-success')
        .append('</div>');
        //Délai avant la fin du message.
        setTimeout(function() {
          $('#msglastComments').html("");
        }, 3000);
      }
  });
});
