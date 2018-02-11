window.onload = function() {
  var signIn = document.getElementById("sign_in");
  var connexionForm = document.getElementById("connexion_form");
  var closed = document.getElementById("closed");
  var signUp = document.getElementById("sign_up");
  var pseudo = document.getElementById("pseudo");
  var error = document.getElementById("error");
  var connexion = document.getElementById("connexion");
  var form = document.getElementById("signin_form");


  connexion.addEventListener('click', function() {
    form.style.display = "none";
  });

  signIn.addEventListener('click', function() {
     connexionForm.style.display = "none";
     form.style.display = "block";
  });

  closed.addEventListener('click', function() {
    annuler();
  });

  function annuler() {
    connexionForm.style.display = "block";
    form.style.display = "none";
  }


  function onSubmit(token) {
    form.submit();
  }
};

//Messages d'erreurs sur le formulaire d'inscription
$(function() {

  $("#signin_form input,#signin_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var name = $("input#pseudo2").val();
      var email = $("input#email2").val();
      var pass = $("input#password2").val();

      var firstName = name; // For Success/Failure Message
      // Check for white space in name for Success/Fail message
      if (firstName.indexOf(' ') >= 0) {
        firstName = name.split(' ').slice(0, -1).join(' ');
      }
      $this = $("#sign_up");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.ajax({
        url: "Login/signup",
        type: "POST",
        data: {
          pseudo: name,
          email2: email,
          password2: pass
        },
        cache: false,
        success: function(data) {
          // regarder ce qu.il y a dans data
          console.log(data);
          data = JSON.parse(data);
          //if data contient le mesg 8
          if(data.hasOwnProperty('message8')) {
            console.log('reussi');
          // faire ca
            $('#success').html("<div class='alert alert-success'>");
            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#success > .alert-success')
              .append("<strong>" + data.message8 + "</strong>");
              $('#success > .alert-success')
              .append('</div>');
              //clear all fields
            $('#signin_form').trigger("reset");
            setTimeout(function() {
              window.location.assign("home");
            }, 1500);
          } else {
            msg = "";
            for(i = 1; i<8; i++) {
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
            //clear all fields
            $('#signin_form').trigger("reset");
          }
        },
        // sinon, en fonction de ce au.il y a dedans
        //remplir msg qvec les ce aue l.on veut dire
        //puis renvoyer ceci
       error: function(data) {
          console.log(data);
          console.log("je suis dans error");
          if(data.hasOwnProperty(!"message8")) {
          // Fail message
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Désolé " + firstName + ", il semble y avoir un problème. Votre inscription n'a pas été validée." + data ));
          $('#success > .alert-danger').append('</div>');
          //clear all fields
          $('#signin_form').trigger("reset");
        }
        },

        complete: function() {
          setTimeout(function() {
            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
          }, 1000);
        }
      });
    },
    filter: function() {
      return $(this).is(":visible");
    },
  });

  $("a[data-toggle=\"tab\"]").click(function(e) {
    e.preventDefault();
    $(this).tab("show");
  });
});

/*When clicking on Full hide fail/success boxes */
$('#pseudo').focus(function() {
  $('#sign_up').html('');
});


//Messages d'erreurs sur le formulaire de connexion
$(function() {

  $("#connexion_form input,#connexion_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var name = $("input#pseudo1").val();
      var pass = $("input#password1").val();

      var firstName = name; // For Success/Failure Message
      // Check for white space in name for Success/Fail message
      if (firstName.indexOf(' ') >= 0) {
        firstName = name.split(' ').slice(0, -1).join(' ');
      }
      $this = $("#btn_submit");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.ajax({
        url: "Login/signin",
        type: "POST",
        data: {
          pseudo1: name,
          password1: pass
        },
        cache: false,
        success: function(data) {
          // regarder ce qu.il y a dans data
          console.log(data);
          data = JSON.parse(data);
          //if data contient le mesg 8
          if(data.hasOwnProperty('message12')) {
          // faire ca
            $('#success1').html("<div class='alert alert-success'>");
            $('#success1 > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#success1 > .alert-success')
              .append("<strong>" + data.message12 + "</strong>");
              $('#success1 > .alert-success')
              .append('</div>');
              //clear all fields
            $('#connexion_form').trigger("reset");
            setTimeout(function() {
              window.location.href = "home";
            }, 1500);
          } else {
            msg = "";
            for(i = 10; i<13; i++) {
              if(data.hasOwnProperty('message'+i)) {
                msg += data['message' + i];
                msg += ' ' ;
              }
            }

            $('#success1').html("<div class='alert alert-danger'>");
            $('#success1 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#success1 > .alert-danger').append($("<strong>").text(msg + " Votre inscription n'a pas été validée." ));
            $('#success1 > .alert-danger').append('</div>');
            //clear all fields
            $('#connexion_form').trigger("reset");
          }
        },
        // sinon, en fonction de ce au.il y a dedans
        //remplir msg qvec les ce aue l.on veut dire
        //puis renvoyer ceci
       error: function(data) {
          console.log(data);
          console.log("je suis dans error");
          if(data.hasOwnProperty(!"message12")) {
          // Fail message
          $('#success1').html("<div class='alert alert-danger'>");
          $('#success1 > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success1 > .alert-danger').append($("<strong>").text("Désolé " + firstName + ", il semble y avoir un problème : " + data ));
          $('#success1 > .alert-danger').append('</div>');
          //clear all fields
          $('#connexion_form').trigger("reset");
        }
        },

        complete: function() {
          setTimeout(function() {
            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
          }, 1000);
        }
      });
    },
    filter: function() {
      return $(this).is(":visible");
    },
  });

  $("a[data-toggle=\"tab\"]").click(function(e) {
    e.preventDefault();
    $(this).tab("show");
  });
});

/*When clicking on Full hide fail/success boxes */
$('#pseudo1').focus(function() {
  $('#btn_submit').html('');
});
