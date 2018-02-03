$(function() {

  $("#signin_form input,#signin_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var name = $("input#pseudo").val();
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
        url: "././themeAdd/mail/form_signin.php",
        type: "POST",
        data: {
          pseudo: name,
          email2: email,
          password2: pass,

        },
        cache: false,
        success: function(data) {
          // Success message
          $('#success').html("<div class='alert alert-success'>");
          $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-success')
            .append("<strong>Votre inscription a bien été validée. </strong>");
          $('#success > .alert-success')
            .append('</div>');
          //clear all fields
          $('#signin_form').trigger("reset");
          console.log(data);
        },
        error: function() {
          // Fail message
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Désolé " + firstName + ", il semble y avoir un problème. Votre inscription n'a pas été validée. Veuillez recommencer s'il vous plait !"));
          $('#success > .alert-danger').append('</div>');
          //clear all fields
          $('#signin_form').trigger("reset");
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
