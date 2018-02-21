$(function() {
  console.log("com's test");
  var id = Cookies.get('id');
  var content = $("textarea#content").val();

  $.ajax({
    url: url + "Home/comments",
    type: "POST",
    data : {
      content : content,
      id : id
    },
    success: function(data) {
      console.log("com's envoyé");
    },
    error: function() {
      console.log("com's pas envoyé");
    }
  });
});
