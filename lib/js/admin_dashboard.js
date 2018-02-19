//Au clique sur la classe "updateCol2" ( qui sont les "li"), on
//lit l'attribut de data-file qui est le nom du fichier qu'on souhaite afficher.
$(".updateCol2").on("click", function() {
  var name = $(this).data('file');
  //Requête Ajax : on récupère le fichier dans function(data) et on l'affiche dans le div.
  $.get("views/admin/"+ name +".php", function(data) {
      $("#colonne2").html(data);
  });
});
