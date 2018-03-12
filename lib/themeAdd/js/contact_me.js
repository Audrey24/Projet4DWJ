$(function() {
  $("#contactForm input,#contactForm textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var name = $("input#name").val();
      var email = $("input#email").val();
      var message = $("textarea#message").val();
      var firstName = name; // For Success/Failure Message
      // Check for white space in name for Success/Fail message
      if (firstName.indexOf(' ') >= 0) {
        firstName = name.split(' ').slice(0, -1).join(' ');
      }
      $this = $("#sendMessageButton");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      console.log("avant ajax");
      $.ajax({
        url: url+ "lib/themeAdd/mail/contact_me.php",
        type: "POST",
        data: {
          name: name,
          email: email,
          message: message,
          recipient: 'guilloux.audrey24@gmail.com'
        },
        cache: false,
        success: function() {
          console.log("test");
          // Success message
          $('#successSendMsg').html("<div class='alert alert-success'>");
          $('#successSendMsg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#successSendMsg > .alert-success')
            .append("<strong>Votre message a bien été envoyé. </strong>");
          $('#successSendMsg > .alert-success')
            .append('</div>');
          //clear all fields
          $('#contactForm').trigger("reset");
          setTimeout(function() {
            $('#successSendMsg').html("");
          }, 3000);
        },
        error: function() {
          // Fail message
          $('#successSendMsg').html("<div class='alert alert-danger'>");
          $('#successSendMsg > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#successSendMsg > .alert-danger').append($("<strong>").text("Désolé, il semble que le serveur ne réponde pas ! Veuillez réésayer plus tard, merci ! "));
          $('#successSendMsg > .alert-danger').append('</div>');
          //clear all fields
          $('#contactForm').trigger("reset");
          setTimeout(function() {
          $('#successSendMsg').html("");
          }, 3000);
        },
        complete: function() {
          setTimeout(function() {
            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
          }, 3000);
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
$('#name').focus(function() {
  $('#successSendMsg').html('');
});
