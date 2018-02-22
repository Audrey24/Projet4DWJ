$(function() {
  $("#write_form input,#write_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      //console.log("Je suis dans submitError");
    },
    submitSuccess: function($form, event) {
      // On empêche la soumission du formulaire (comportement par défaut)
      event.preventDefault();
      //console.log("Je suis dans submitSucces");
      //On assigne la valeur du bouton "valider" au $this.
      $this = $("#submitbtn_autor");
      // On désactive le bouton "valider" jusqu'à ce que l'appel Ajax soit terminé pour éviter les messages en double
      $this.prop("disabled", true);
      //Requête Ajax pour envoyeu au serveur les éléments du formulaire en tant que chaîne dans 'data' grâce à 'serialize()'.
      $.ajax({
        url: "Admin/create",
        type: "POST",
        data: $form.serialize(),
        cache: false,
        success: function(data) {
        //Si on a bien contacté le serveur et récupéré les données, on envoit un message de confirmation.
          //console.log(data);
            $('#Send_msg').html("<div class='alert alert-success'>");
            $('#Send_msg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#Send_msg > .alert-success')
              .append("<strong>" + "Fichier enregistré" + "</strong>");
              $('#Send_msg > .alert-success')
              .append('</div>');
              //On efface les champs/
            $('#write_form').trigger("reset");
            //Délai avant la fin du message.
            setTimeout(function() {
              $('#Send_msg').html("");
          }, 3000);
        },
        //Si on n'a pas contacté le serveur (requête Ajax qui n'a pas abouti), on envoit un message d'erreur.
       error: function(data) {
          //console.log(data);
          //console.log("Je suis dans error");
          $('#Send_msg').html("<div class='alert alert-danger'>");
          $('#Send_msg > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#Send_msg > .alert-danger').append($("<strong>").text("Désolé, votre fichier n'a pas été sauvegardé !" ));
          $('#Send_msg > .alert-danger').append('</div>');
          //Délai avant la fin du message.
          setTimeout(function() {
            $('#Send_msg').html("");
          }, 3000);
        },

        complete: function() {
          //On réactive le bouton "valider" lorsque l'appel AJAX est terminé
          setTimeout(function() {
            $this.prop("disabled", false);
          }, 1000);
        }
      });
    },

        /*filter: function() {
          return $(this).is(":visible");
      },*/
    });

        /*$("a[data-toggle=\"tab\"]").click(function(e) {
          e.preventDefault();
          $(this).tab("show");
      });*/

        //On met en forme le calendrier du champs "Publication différée".
        $(document).ready(function(){
          //On récupère le nom de l'input.
          var date_input= $('input[name="deferred_date"]');
          //On sélectionne le conteneur div `.bootstrap-iso ' pour dire au sélecteur de date d'y ajouter le calendrier.
          var container= $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

          //On rajoute des paramètres pour que le calendrier soit en français car par défaut c'est de l'anglais.
          $.fn.datepicker.dates['fr'] = {
            days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
            daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
            daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
            months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
            today: "Aujourd'hui",
            clear: "Effacer",
            format: "yyyy-mm-dd",
            //Rmq : utiliser la même syntaxe que 'format'.
            titleFormat: "yyyy-mm-dd",
            weekStart: 1
          };

          //On appelle la fonction avec ces options.
          date_input.datepicker({
            format: "yyyy-mm-dd",
            language : 'fr',
            container: container,
            todayHighlight: true,
            autoclose: true,
          });
        });
      });
