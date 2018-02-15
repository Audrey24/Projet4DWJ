$(".updateCol2").on("click", function() {
  var name = $(this).data('file');
  $.get("views/admin/"+ name +".php", function(data) {
      $("#colonne2").html(data);
  });
});
