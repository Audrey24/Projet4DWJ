$('#commenter').on('click', function() {
  console.log("com's test");
  
  var content = $("#comment").val();
  console.log(content);

  $.ajax({
    url: url + "Home/comments",
    type: "POST",
    data : {
      content : content,
      id_user : id,
      id_text : $('#newspage').data('id')


    },
    success: function(data) {

        var date = new Date();

        var text = '<tr><td class="pseudo_comments">' + pseudo + '</td>';
             text += '<td class="content_comments" scope="row">' + content + '</td>';
             text += '<td class="date_comments">' + date.toLocaleDateString("fr-FR") + '</td></tr>';
    
          $("#contain_comments").append(text);

        $('#commentMsg').html("<div class='alert alert-success'>");
            $('#commentMsg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#commentMsg > .alert-success').append("<strong>" + "Message envoyé" + "</strong>");
              $('#commentMsg > .alert-success').append('</div>');
              //On efface les champs/
            $('#comment').val("");
            //Délai avant la fin du message.
            setTimeout(function() {
              $('#commentMsg').html("");
          }, 3000);

    },
    error: function() {
       $('#commentMsg').html("<div class='alert alert-danger'>");
          $('#commentMsg > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
            $('#commentMsg > .alert-danger').append("<strong>" + "Désolé, votre message n'a pas pu être envoyé !" + "</strong>" );
            $('#commentMsg > .alert-danger').append('</div>');
          //On efface les champs/
          $('#comment').val("");
          //Délai avant la fin du message.
          setTimeout(function() {
            $('#commentMsg').html("");
          }, 3000);
        },
    })
  });


$(function() {

  $.ajax({
    url: url + "Home/getComments",
    type: "POST",
    data : {
      id_text : $('#newspage').data('id')
    },
     success: function(data) {
    
    //Si la requête a fonctionné, on a récupéré les articles et on les insère dans le div.
    //console.log(data);
      data = JSON.parse(data);

    //Boucle qui lit tous les articles.
    for (var i = 0; i < data.length; i++) {
    //console.log(data);
    //console.log("Articles affichés");

    var text = '<tr><td class="pseudo_comments">' + data[i].pseudo + '</td>';
    text += '<td class="content_comments" scope="row">' + data[i].content + '</td>';
    text += '<td class="date_comments">' + data[i].published_date + '</td></tr>';
    
    $("#contain_comments").append(text);
    }
    }


});
});