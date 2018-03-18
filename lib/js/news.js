//Requête Ajax : on appelle la fonction pour obtenir les derniers articles.
$.ajax({
  async: true,
  url: url + "Home/getNews",
  type: "POST",
  success: function(data) {
    //Si la requête a fonctionné, on a récupéré les articles et on les insère dans le div.
    data = JSON.parse(data);

    //Boucle qui lit tous les articles.
    for (var i = 0; i < data.length; i++) {
    //Création d'une var news pour pouvoir modifier le contenu (nb de caractères à afficher et où couper la fin de l'extrait).
      var news = data[i].content.substring(0, 100);

      if (news.lastIndexOf(">")>50) {
        news = news.substring(0, news.lastIndexOf(">")+1);
      }

      news += "...";

      //Création d'une var date pour pouvoir modifier le format reçu de la bdd.
      var dateslice = data[i].deferred_date.split(" ");
      var date = new Date(Date.parse(dateslice[0]+"T"+dateslice[1]));
      console.log(date);

      var text = '<tr><td class="title_news" scope="row">' + data[i].title +'</td>';
      text += '<td class="content_news">' + news + '</td>';
      text += '<td class="date_news">' + date.toLocaleDateString("fr-FR") + '</td>';
      text += '<td class="see_news"><a href="home/news/'+ data[i].id +'"><i class="fa fa-search"></i></a></td></tr>';

      $("#contain_news").append(text);
    }
  },
});
