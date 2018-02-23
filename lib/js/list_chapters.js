
//Afficher les commentaires.
$(function() {
  //Requête pour envoyer au serveur l'id du texte.
  $.ajax({
    url: url+ "Last_chapters/getChapters",
    type: "POST",
    data :{},
    //Si la requête a fonctionné, on a récupéré les commentaires et on les insère dans le div.
     success: function(data) {
      data = JSON.parse(data);
      //Boucle qui lit tous les commentaires.
      for (var i = 0; i < data.length; i++) {
      //console.log(data);
        var text = '<tr class="chapter"><td class="id_chapter">' + data[i].id + '</td>';
        text += '<td class="title_chapter" scope="row">' + data[i].title + '</td>';
        text += '<td class="date_chapter">Publié le : ' + data[i].publication_date + '</td>';
        text += '<td class="read_chapter btn btn-info btn-xs"  data-id="' + data[i].id +'">Lire</td></tr>';
        $("#contain_chapters").append(text);
      }
    }
  });
});

//Quand on clique sur la ligne du tableau, on ouvre la page "Current_chapter" avec le chapitre sélectionné.
$(document).on('click','.read_chapter', function() {
  id = $(this).data('id');
  window.location.href = url + "Current_chapter/read/" + id;
});
