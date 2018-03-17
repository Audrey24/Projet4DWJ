$(function() {
//Evenement au clique de la classe "delete".
$(document).on('click','.delete',function() {
  //On récupère l'id mis dans le bouton "valider" et on le range dans une var.
  var id = $(this).data('id');
  var type = $("#colonne2").data("type");
  //On récupère dans une var, la ligne du tableau qui comporte l'id récupéré plus tôt.
  var line = $('#tr'+id);
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.ajax({
    async: true,
    url : url+"admin/deleteAJAX/",
    type :"POST",
    data : {
      id : id,
      type : type
    },
    success: function(data){
      //console.log(data);
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
    }
});
});

//Evenement au clique de la classe "edit".
$(document).on('click','.edit',function(event) {
  //On récupère l'id du texte sélectionné.
console.log(event);

  var id = $(this).data('id');
  var type = $("#colonne2").data("type");
  //Requête Ajax : on appelle la fonction qui prend en paramètre d'url l'id sélectionné.
  $.ajax({
    async: true,
    url : "admin/getOne/",
    type : "POST",
    data : {
      id : id,
      type : type
    },
    success : function(data) {
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
          $("#type").val(type);

          var date = data.deferred_date.split("/");

          $("#deferred_date").val(date[2]+ "-" +date[1]+ "-" +date[0]);
          //On récupère le type de l'objet et on l'associe à l'id car ils ont le même "nom".
          //Donc si on récupère un type "chapitre" on clique sur le bouton chapitre.
          //Moins répétitif que de faire ça pour chaque id de chaque boutons différent.
          $("#" + type).prop('checked',true);
       }, 2000);
     }
   });
  });
});
