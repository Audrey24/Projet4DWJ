$(function(){
//Requête Ajax : on appelle la fonction pour obtenir le chapitre suivant.
$.ajax({
  async: true,
  url: url + "Current_chapter/next",
  type: "POST",
  data : {
   id : $("#flipbook").data("id")
 },
 //Si la requête a réussi, on modifie le lien du bouton "next" avec l'id du prochain chapitre.
  success: function(data) {
    if (data == "") {
      $("#nextLink").attr('href', url + "/Current_chapter/no_read");
    } else {
        $("#nextLink").attr('href', url + "Current_chapter/read/" + data);
      }
  },
  error: function() {
  console.log("Pas de chapitre affiché");
  }
});

$.ajax({
  async: true,
  url: url + "Current_chapter/prev",
  type: "POST",
  data : {
   id : $("#flipbook").data("id")
 },
 //Si la requête a réussi, on modifie le lien du bouton "prev" avec l'id du chapitre précédent.
  success: function(data) {
    //console.log(data);
    if (data == "") {
      $("#prevLink").attr('href', url + "/Current_chapter/no_read");
    } else {
        $("#prevLink").attr('href', url + "Current_chapter/read/" + data);
      }
  },
  error: function() {
  console.log("Pas de chapitre affiché");
  }
});

$("#saveChapter").on('click', function(e) {
  console.log("dedans");
  $.ajax({
    async: true,
    url: url + "Current_chapter/updateCurrent_chapter",
    type: "POST",
    data : {
     id : $("#flipbook").data("id"),
     read_page : $("#flipbook").turn("page")
   },
   //Si la requête a réussi, on modifie le lien du bouton "prev" avec l'id du chapitre précédent.
    success: function(data) {
      $('#markChapter').html("<div class='alert alert-success'>");
      $('#markChapter > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
      $('#markChapter > .alert-success').append("<strong>" + "Votre lecture a bien été sauvegardée" + "</strong>");
      $('#markChapter > .alert-success').append('</div>');
      //Délai avant la fin du message.
      setTimeout(function() {
        $('#markChapter').html("");
      }, 3000);
    },
    error: function() {}
  });
  });
});
