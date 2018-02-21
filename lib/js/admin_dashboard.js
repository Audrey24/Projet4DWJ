//Au clique sur la classe "updateCol2" ( qui sont les "li"), on
//lit l'attribut de data-file qui est le nom du fichier (et de la vue) qu'on souhaite afficher.
//De plus, on récupère celui du type pour pouvoir afficher les textes par types.
$(".updateCol2").on("click", function() {
  var name = $(this).data('file');
  var type =  $(this).data('type');

  //Requête Ajax : on récupère le fichier dans function(data) et on l'affiche dans le div en fonction du type précisé.
  $.get("views/admin/"+ name +".php", function(data) {
      $("#colonne2").html(data);
      $("#colonne2").data("type", type);

  });
});
