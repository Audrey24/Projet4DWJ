$(function(){
//Requête Ajax : on appelle la fonction pour obtenir le chapitre suivant.
$.ajax({
  url: url + "Current_chapter/next",
  type: "POST",
  data : {
   id : $("#book").data("id")
 },
 //Si la requête a réussi, on modifie le lien du bouton "next" avec l'id du prochain chapitre.
  success: function(data) {
  console.log(data);
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
  url: url + "Current_chapter/prev",
  type: "POST",
  data : {
   id : $("#book").data("id")
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
});
