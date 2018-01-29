// Sample using dynamic pages with turn.js

	var numberOfPages = 1000;


	// Adds the pages that the book will need
	function addPage(page, book) {
		// 	First check if the page is already in the book
		if (!book.turn('hasPage', page)) {
			// Create an element for this page
			var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page}).html('<i class="loader"></i>');
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

		document.getElementById('next').addEventListener("click", function() { // image suivante
   			$('#book').turn('next');
		});

		document.getElementById('prev').addEventListener("click", function() { // image suivante
   			$('#book').turn('previous');
		});

	});
