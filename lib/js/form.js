//Variables déclarées en JS car problème d'affichage de la modale quand je les déclare avec Jquery.
window.onload = function() {
  var signIn = document.getElementById("sign_in");
  var connexionForm = document.getElementById("connexion_form");
  var closed = document.getElementById("closed");
  var signUp = document.getElementById("sign_up");
  var pseudo = document.getElementById("pseudo");
  var error = document.getElementById("error");
  var connexion = document.getElementById("connexion");
  var form = document.getElementById("signin_form");
  var forgetLogin = document.getElementById("forgetLogin");
  var formForgetLogin = document.getElementById("getLogin");
  var btnForgetLogin = document.getElementById("btnGetLogin");

  form.style.display = "none";
  formForgetLogin.style.display = "none";


  $(document).on('click','.Btnconnexion',function() {
    grecaptcha.reset();
    grecaptcha.execute();
  });


//Quand on clique sur le bouton "Connexion" dans le menu, seul le formulaire de connexion s'affiche.
connexion.addEventListener('click', function() {
    form.style.display = "none";
    formForgetLogin.style.display = "none";

    grecaptcha.reset();
    grecaptcha.execute();
});

//Quand on clique sur le bouton "Créer votre compte", le formulaire de connexion s'efface et celui d'inscription s'affiche.
signIn.addEventListener('click', function() {
     connexionForm.style.display = "none";
     formForgetLogin.style.display = "none";
     form.style.display = "block";
});

forgetLogin.addEventListener('click', function() {
     connexionForm.style.display = "none";
     form.style.display = "none";
     formForgetLogin.style.display = "block";
});

btnForgetLogin.addEventListener('click', function() {
      $('#myModal').modal("hide");
});

//Quand on clique sur la croix, la modale se ferme.
closed.addEventListener('click', function() {
    annuler();
});

//Fonction qui remet les formulaires à l'état initial et nettoie les champs messages.
function annuler() {
    connexionForm.style.display = "block";
    form.style.display = "none";
    formForgetLogin.style.display = "none";
    $('#success').html("");
    $('#success1').html("");
  }
};

//Formulaire d'inscription
$(function() {

  $("#signin_form input,#signin_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
    //console.log("Je suis dans submitError de Formjs");
    },
    submitSuccess: function($form, event) {
      //console.log("Je suis dans submitSucces de Formjs");
      // On empêche la soumission du formulaire (comportement par défaut)
      event.preventDefault();
      //On récupère dans des var les valeurs des champs.
      var name = $("input#pseudo2").val();
      var email = $("input#email2").val();
      var pass = $("input#password2").val();
      var captcha = grecaptcha.getResponse();
      //console.log(captcha);
      var firstName = name;
      //Enlèver l'espace si l'user a mis un espace devant son pseudo.
      if (firstName.indexOf(' ') >= 0) {
        firstName = name.split(' ').slice(0, -1).join(' ');
      }
      //On assigne la valeur du bouton "créer" au $this.
      $this = $("#sign_up");
      // On désactive le bouton "créer" jusqu'à ce que l'appel Ajax soit terminé pour éviter les messages en double
      $this.prop("disabled", true);
      //Requête Ajax : appel de la fonction.
      $.ajax({
        async: true,
        url: url+ "Login/signup",
        type: "POST",
        data: {
          pseudo: name,
          email2: email,
          password2: pass,
          recaptcha: captcha
        },
        cache: false,
        success: function(data) {
        //Si la requête a abouti, on envoit un message de confirmation
        console.log(data);
        data = JSON.parse(data);

          //Les données recues du serveur sont un string donc on les "parse" pour les transformer en objet JS et on les insère dans "data".
          if(data.hasOwnProperty('message9')) {
            //Si les données retournées ont cette propriété "message 9", on affiche un msg de réussite
            //console.log('Réussite');
            $('#success').html("<div class='alert alert-success'>");
            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#success > .alert-success')
              .append("<strong>" + data.message9 + "</strong>");
              $('#success > .alert-success')
              .append('</div>');
            //On efface les champs.
            $('#signin_form').trigger("reset");
            //Après délai, on redirige vers Home.
            setTimeout(function() {
              $('#myModal').modal('hide');
              location.reload(true);
          }, 3000);
          } else {
            //Si les données retournées n'ont pas cette propriété "message 9".
            //on fait une boucle pour chercher quel msg est retourné et on l'affiche dans le msg d'erreur.
            msg = "";
            for(i = 1; i<10; i++) {
              if(data.hasOwnProperty('message'+i)) {
                msg += data['message' + i];
                msg += ' ' ;
              }
            }
            $('#success').html("<div class='alert alert-danger'>");
            $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#success > .alert-danger').append($("<strong>").text("" + msg + "" + "Votre inscription n'a pas été validée." ));
            $('#success > .alert-danger').append('</div>');
            $('#signin_form').trigger("reset");
            setTimeout(function() {
              $('#success').html("");
            }, 3000);
          }
        },

        //Si la requête n'a pas abouti, on envoit un message d'erreur.
        error: function(data) {
          //console.log(data);
          //console.log("je suis dans error de Form.js");
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Désolé " + firstName + ", il semble y avoir un problème. Votre inscription n'a pas été validée." + data ));
          $('#success > .alert-danger').append('</div>');
          $('#signin_form').trigger("reset");
          setTimeout(function() {
            $('#success').html("");
          }, 3000);
        },

        complete: function() {
          //On réactive le bouton "créer" lorsque l'appel AJAX est terminé
          setTimeout(function() {
            $this.prop("disabled", false);
          }, 1000);
        }
      });
    },
  });
});


//Formulaire de connexion
$(function() {

  $("#connexion_form input,#connexion_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      console.log("erreur connexion");
    },
    submitSuccess: function($form, event) {
      event.preventDefault();
      // On empêche la soumission du formulaire (comportement par défaut)

      //On récupère dans des var les valeurs des champs.
      var name = $("input#pseudo1").val();
      var pass = $("input#password1").val();

      var firstName = name;
      //Enlèver l'espace si l'user a mis un espace devant son pseudo.
      if (firstName.indexOf(' ') >= 0) {
        firstName = name.split(' ').slice(0, -1).join(' ');
      }
      //On assigne la valeur du bouton "valider" au $this.
      $this = $("#btn_submit");
      // On désactive le bouton "créer" jusqu'à ce que l'appel Ajax soit terminé pour éviter les messages en double
      $this.prop("disabled", true);
      //Requête Ajax : on appelle la fonction.
      $.ajax({
        async: true,
        url: url+ "Login/signin",
        type: "POST",
        data: {
          pseudo1: name,
          password1: pass
        },
        cache: false,
        success: function(data) {
        //Si la requête a abouti, on envoit un message de confirmation.
          console.log(data);
          data = JSON.parse(data);
          //Les données recues du serveur sont un string donc on les "parse" pour les transformer en objet JS et on les insère dans "data".
          if(data.hasOwnProperty('message12')) {
            //Si les données retournées ont cette propriété "message 12", on affiche un msg de réussite
            $('#success1').html("<div class='alert alert-success'>");
            $('#success1 > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#success1 > .alert-success')
              .append("<strong>" + data.message12 + "</strong>");
              $('#success1 > .alert-success')
              .append('</div>');
            //On efface les champs.
            $('#connexion_form').trigger("reset");
            //Après un délais, on redirige vers Home.
            setTimeout(function() {
              $('#myModal').modal('hide');
              location.reload(true);
          }, 3000);
          } else {
            //Si les données retournées n'ont pas cette propriété "message 12".
            //on fait une boucle pour chercher quel msg est retourné et on l'affiche dans le msg d'erreur.
            msg = "";
            for(i = 10; i<14; i++) {
              if(data.hasOwnProperty('message'+i)) {
                msg += data['message' + i];
                msg += ' ' ;
              }
            }
            $('#success1').html("<div class='alert alert-danger'>");
            $('#success1 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#success1 > .alert-danger').append($("<strong>").text(msg));
            $('#success1 > .alert-danger').append('</div>');
            //On nettoie les champs
            $('#connexion_form').trigger("reset");
            //On efface le msg après un délais de 3s.
            setTimeout(function() {
              $('#success1').html("");
            }, 3000);
          }
        },

        //Si la requêt n'a pas abouti, on envoit un message d'erreur.
        error: function(data) {
          //console.log(data);
          //console.log("je suis dans error de Formjs");
          $('#success1').html("<div class='alert alert-danger'>");
          $('#success1 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success1 > .alert-danger').append($("<strong>").text("Désolé " + firstName + ", il semble y avoir un problème : " + data ));
          $('#success1 > .alert-danger').append('</div>');
          //On nettoie les champs
          $('#connexion_form').trigger("reset");
          //Après 3s, on efface le msg.
          setTimeout(function() {
            $('#success1').html("");
          }, 3000);

        },
        complete: function() {
          //On réactive le bouton "créer" lorsque l'appel AJAX est terminé
          setTimeout(function() {
            $this.prop("disabled", false);
          }, 1000);
        }
      });
    },
  });
});



//Formulaire pour récupérer son mot de passe
$(function() {
  $("#getLogin input").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {},
    submitSuccess: function($form, event) {
      // On empêche la soumission du formulaire (comportement par défaut)
      event.preventDefault();
      //On récupère dans des var les valeurs des champs.
      var mail = $("input#mailGetLogin").val();
      //On assigne la valeur du bouton "valider" au $this.
      $this = $("#btnGetLogin");
      // On désactive le bouton "créer" jusqu'à ce que l'appel Ajax soit terminé pour éviter les messages en double
      $this.prop("disabled", true);
      //Requête Ajax : on appelle la fonction.
      $.ajax({
        async: true,
        url: url+ "Login/generateLog",
        type: "POST",
        data: {
          mail: mail
        },
        cache: false,
        success: function(data) {
          console.log(data);
        //Si la requête a abouti, on envoit un message de confirmation.
        $('#getLogin').trigger("reset");
        $('#getLogin').modal("hide");
        }
      });
    },
  });
});

//Formulaire pour réinitialiser son mot de passe
$(function() {
  $("#resetLog input").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {},
    submitSuccess: function($form, event) {
      // On empêche la soumission du formulaire (comportement par défaut)
      event.preventDefault();
      //On récupère dans des var les valeurs des champs.
      var pass = $("input#resetPass").val();
      var id = $('#resetLog').data('id');

      // On désactive le bouton "créer" jusqu'à ce que l'appel Ajax soit terminé pour éviter les messages en double
      $("#btnReset").prop("disabled", true);
      //Requête Ajax : on appelle la fonction.
      $.ajax({
        async: true,
        url: url+ "Login/updateLog",
        type: "POST",
        data: {
          pass: pass,
          id : id
        },
        cache: false,
        success: function(data) {
        //Si la requête a abouti, on envoit un message de confirmation.
          $('#resetSuccess').html("<div class='alert alert-success'>");
          $('#resetSuccess > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#resetSuccess > .alert-success').append("<strong>" + "Votre mot de passe a bien été réinitialisé" + "</strong>");
          $('#resetSuccess > .alert-success').append('</div>');
          //On nettoie les champs
          $('#resetLog').trigger("reset");
          //On efface le msg après un délais de 3s.
          setTimeout(function() {
            $('#resetSuccess').html("");
            window.location.replace(url+"home");
          }, 3000);
          },
        error: function() {
          $('#resetSuccess').html("<div class='alert alert-danger'>");
          $('#resetSuccess > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
          $('#resetSuccess > .alert-danger').append("<strong>" + "Désolé, il semble y avoir un problème avec le serveur. Votre mot de passe n'a pas pu être modifié ! Veuillez recommencer s'il vous plait" + "</strong>" );
          $('#resetSuccess > .alert-danger').append('</div>');
          //On efface les champs/
          $('#resetLog').trigger("reset");
          //Délai avant la fin du message.
          setTimeout(function() {
          $('#resetSuccess').html("");
        }, 3000);
        },
      });
    }
  });
});
