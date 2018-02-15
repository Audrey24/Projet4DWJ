  <form id="write_form" method="post" action="Admin/create">
    <div><p>Que souhaitez-vous rédiger ?</p>
      <input type="radio" name="typeTexte" id="article" value="article" />
      <label for="article">Article</label></br>

      <input type="radio" name="typeTexte" id="chapitre" value="chapitre" />
      <label for="chapitre">Chapitre</label>
    </div><br />

    <textarea id="editor" name="editor"></textarea></br>

    <div id="Send_msg"></div></br>
    <input id="submitbtn_autor" type="submit" class=" btn btn-success col-lg-12 col-md-12 col-sm-12" />
  </form>

  <script src="lib/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({  selector:'textarea',
                          height: 550,
                          language: 'fr_FR'});</script>

<script src="lib/js/admin_write.js"></script>
