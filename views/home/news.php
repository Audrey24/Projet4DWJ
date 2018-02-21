<?php setcookie('id', $id, time() + 365*24*3600, null, null, false, true); ?>

<div id="newspage" class="col-lg-6 offset-lg-3">
  <h3><?php echo($this->data['title']); ?></h3></br>
  <div><?php echo($this->data['content']); ?></div></br>
  <p id="published">Publié le : <?php echo($this->data['publication_date']); ?></p>
</div>

<div class="container">
  <div class="row">
      <div class="col-lg-3 offset-lg-1 control-group">
    <?php if (!empty(Session::get('pseudo'))) {
    ?>

      <div class="form-group floating-label-form-group controls">
        <label>Commenter</label>
        <textarea placeholder="Votre commentaire" id="comment" name ="comment" required data-validation-required-message="Veuillez écrire un commentaire."></textarea>
      </div>
      <button type="submit" class="btn btn-success col-lg-12 col-md-12">Commenter</button>
      <?php
} ?>

    </div>

    <?php echo Session::get('id');?>


  <div class="col-lg-4 offset-lg-1 control-group">
    <table class="table table-striped">
      <tbody id="contain_comments"></tbody>
    </table>
  </div>
</div>
</div>

<script type="text/javascript" src="lib/js/comments.js" defer></script>
