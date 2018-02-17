var test = 0;
$(function() {
  $.get('admin/textsList', function(o) {
    test = o;
    for (var i = 0; i < o.length; i++) {
      $("#containList").append ('<tr><th scope="row">' + o[i].id +'</th><td>' + o[i].type + '</td><td>' + o[i].title + '</td><td id="contentList">' + o[i].content.substring(0, 500) + '</td><td>' + o[i].publication_date + '</td><td class="edit" data-id ="' + o[i].id + '"><i class="fa fa-pencil fa-lg"></i></td><td class="delete" data-id ="' + o[i].id + '"><i class="fa fa-times"></i></td></tr>');
    }
  },'json');

$(document).on('click','.delete',function() {
  var line = $(this);
  var id = $(this).data('id');
  $.get("admin/delete/" + id , function(data){
    line.parent().remove();
    $('#deletemsg').html("<div class='alert alert-success'>");
    $('#deletemsg > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
      .append("</button>");
      $('#deletemsg > .alert-success')
      .append("<strong>" + "Le fichier a bien été supprimé ! " + "</strong>");
      $('#deletemsg > .alert-success')
      .append('</div>');
      setTimeout(function() {
        $('#deletemsg').html("");
      }, 3000);

  });
});
});

$(document).on('click','.edit',function() {
  var id = $(this).data('id');
  $.get("admin/getOne/" + id , function(data){

    $("#btn_write").trigger("click");
        setTimeout(function() {
          data = JSON.parse(data);
          var tiny = tinymce.get('editor');
          tiny.setContent(data.content);
          $("#title").val(data.title);
        }, 1000);

  });
});
