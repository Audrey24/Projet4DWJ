$(function(){
//Requête Ajax : on appelle la fonction pour obtenir le chapitre suivant.
$('#extract_book').turn({
  height : '800px',
});

$(document).keydown(function(e){

  var previous = 37, next = 39;

  switch (e.keyCode) {
    case previous:

      $('#extract_book').turn('previous');

    break;
    case next:

      $('#extract_book').turn('next');

    break;
  }

});



});
