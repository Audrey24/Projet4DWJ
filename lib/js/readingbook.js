//Requête Ajax : on appelle la fonction pour obtenir le dernier chapitre.
$.ajax({
  url: "Current_chapter/getLastChapter",
  type: "POST",
  success: function(data) {
    //Si la requête a fonctionné, on a récupéré le dernier chapitre et on l'insère dans le div.
    data = JSON.parse(data);
    //console.log(data);
    $("#book").append("<div class='cover'><h1>" + data.title + "</h1></div>");
    $("#book").append("<div>" + data.content + "</div>");
    console.log(data);

  },
  error: function() {
    console.log("Pas de chapitre affiché");
  }
});
