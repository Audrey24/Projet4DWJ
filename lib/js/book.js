$(function(){
//Requête Ajax : on appelle la fonction pour obtenir le chapitre suivant.
$('#flipbook').turn({
  height : '800px',

});
});


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

/*var numberOfPages = 10;

// Adds the pages that the book will need
function addPage(page, book) {
  // 	First check if the page is already in the book
  if (!book.turn('hasPage', page)) {
    // Create an element for this page
    var element = $('#book');
    // If not then add the page
    book.turn('addPage', element, page);
    // Let's assum that the data is comming from the server and the request takes 1s.
    setTimeout(function(){
        element.html('<div class="data">Texte de Forteroche '+page+'</div>');
    }, 1000);
  }
}

$(window).ready(function(){
  $('#book').turn({acceleration: true,
            pages: numberOfPages,
            elevation: 50,
            gradients: !$.isTouch,
            when: {
              turning: function(e, page, view) {

                // Gets the range of pages that the book needs right now
                var range = $(this).turn('range', page);

                // Check if each page is within the book
                for (page = range[0]; page<=range[1]; page++)
                  addPage(page, $(this));

              },

              turned: function(e, page) {
                $('#page-number').val(page);
                //.val() = Obtenez la valeur actuelle du premier élément de l'ensemble des éléments correspondants ou définissez la valeur de chaque élément correspondant.//
              }
            }
          });

  $('#number-pages').html(numberOfPages);

  $('#page-number').keydown(function(e){

    if (e.keyCode==13)
      $('#book').turn('page', $('#page-number').val());

  });
});

//bind = Attacher un gestionnaire à un événement pour les éléments.//
$(window).bind('keydown', function(e){

  if (e.target && e.target.tagName.toLowerCase()!='input')
    if (e.keyCode==37)
      $('#book').turn('previous');
    else if (e.keyCode==39)
      $('#book').turn('next');

  });

  $('#next').bind("click", function(e) { // image suivante
      $('#book').turn('next');
  });

  $('#prev').bind("click", function(e) { // image suivante
      $('#book').turn('previous');
  });*/
