  <form id="write_form" method="post" action="Admin/create">
    <div><p>Que souhaitez-vous rédiger ?</p>
      <input type="radio" name="typeTexte" id="article" value="Article" required/>
      <label for="article">Article</label></br>

      <input type="radio" name="typeTexte" id="chapitre" value="Chapitre" required />
      <label for="chapitre">Chapitre</label>
    </div><br />

    <div><label>Titre</label> : <input type="text" name="title" id="title" class="col-lg-12" required/></div></br>

    <textarea id="editor" name="editor"></textarea></br>

    <div id="Send_msg"></div></br>
    <input id="submitbtn_autor" type="submit" class=" btn btn-success col-lg-4 col-md-4 col-sm-4 offset-lg-1" />
    <input class="btn btn-info col-lg-4 col-md-4 col-sm-4 offset-lg-2 offset-sm-3" value="Corbeille"/>
  </form>

  <script src="lib/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({  selector:'textarea',
                          height: 550,
                          language: 'fr_FR'});</script>

<script src="lib/js/admin_write.js"></script>
