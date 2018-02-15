$(function() {
console.log ("FDP");
  $("#write_form input,#write_form textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      $this = $("#submitbtn_autor");
      $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
      $.ajax({
        url: "Admin/create",
        type: "POST",
        data: $form.serialize(),
        cache: false,
        success: function(data) {
          // regarder ce qu.il y a dans data
          console.log("succes");
            $('#Send_msg').html("<div class='alert alert-success'>");
            $('#Send_msg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
              $('#Send_msg > .alert-success')
              .append("<strong>" + "Fichier enregistré" + "</strong>");
              $('#Send_msg > .alert-success')
              .append('</div>');
              //clear all fields
            $('#write_form').trigger("reset");
            setTimeout(function() {
              $('#Send_msg').html("");
            }, 3000);
        },
        // sinon, en fonction de ce au.il y a dedans
        //remplir msg qvec les ce aue l.on veut dire
        //puis renvoyer ceci
       error: function(data) {
          console.log(data);
          console.log("je suis dans error");
          // Fail message
          $('#Send_msg').html("<div class='alert alert-danger'>");
          $('#sSend_msg > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#Send_msg > .alert-danger').append($("<strong>").text("Désolé, votre fichier n'a pas été sauvegardé !" ));
          $('#Send_msg > .alert-danger').append('</div>');
          setTimeout(function() {
            $('#Send_msg').html("");
          }, 3000);

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
