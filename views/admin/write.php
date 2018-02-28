  <form id="write_form" method="post" action="Admin/create">
    <div><p>Que souhaitez-vous rédiger ?</p>
      <input type="radio" name="typeTexte" id="Article" value="Article" required/>
      <label for="article">Article</label></br>

      <input type="radio" name="typeTexte" id="Chapitre" value="Chapitre" required />
      <label for="chapitre">Chapitre</label></br>

      <input type="radio" name="typeTexte" id="Brouillon" value="Brouillon" required />
      <label for="brouillon">Brouillon</label></br>

      <input type="text" name="id" id="id" class="col-lg-1 offset-lg-11"/>
    </div><br />



    <div><label>Titre</label> : <input type="text" name="title" id="title" class="col-lg-12" required/></div></br>

    <textarea id="editor" name="editor"></textarea></br>

    <div class="bootstrap-iso">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group"> <!-- Date input -->
                <label class="control-label" for="date">Publication différée</label>
                <input class="form-control" id="deferred_date" name="deferred_date" placeholder="AAAA/MM/JJ" type="text"/>
              </div>
          </div>
        </div>
      </div>
    </div>


    <div id="Send_msg"></div></br>
    <input id="submitbtn_autor" type="submit" class=" btn btn-success col-lg-12 col-md-12 col-sm-12" />
  </form>

  <script src="lib/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({  selector:'textarea',
                          height: 550,
                          language: 'fr_FR'});</script>

<script src="lib/js/admin_write.js"></script>
