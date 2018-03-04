$(function(){
//Requête Ajax : on appelle la fonction pour obtenir le chapitre suivant.
$('#flipbook').turn({
  height : '800px',

});
if ($('#flipbook').data("id") == chapter) {
$('#flipbook').turn('page', $('#flipbook').data("pagecurrent"));
}

$(document).keydown(function(e){

  var previous = 37, next = 39;

  switch (e.keyCode) {
    case previous:

      $('#flipbook').turn('previous');

    break;
    case next:

      $('#flipbook').turn('next');

    break;
  }

});

});
