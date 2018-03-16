<div id="newspage" data-id="<?php echo($this->data['id']); ?>" class="col-lg-6 offset-lg-3">
  <h3><?php echo($this->data['title']); ?></h3></br>
  <div><?php echo($this->data['content']); ?></div></br>
  <p id="published">Publié le : <?php $date = new DateTime($this->data['deferred_date']);
                                      echo $date->format('d/m/Y');?></p>
</div></br>

<hr>

<div class="container">
  <div class="row">
      <div class="col-lg-3 col-sm-12 offset-lg-1 control-group">
    <?php if (!empty(Session::get('pseudo'))) {
                                          ?>

      <div class="form-group floating-label-form-group controls">
        <label>Commenter</label>
        <textarea placeholder="Votre commentaire" id="comment" name ="comment" required data-validation-required-message="Veuillez écrire un commentaire."></textarea>
      </div>
      <div id="commentMsg"></div></br>
      <button type="submit" class="btn btn-success col-lg-12 col-md-12" id="commenter">Commenter</button>
      <?php
                                      } else {
                                          ?> <div class="connexionMsg">Vous devez être connecté pour pouvoir laisser un commentaire !</div></br>
           <button class="btn btn-info col-lg-12 col-md-12" data-toggle="modal" data-target="#myModal">Connexion</button><?php
                                      } ?>

    </div></br>

  <div class="col-lg-7 col-sm-12 offset-lg-1 control-group">
    <p id='lastComments'>Derniers commentaires</p>
    <table class="table table-sm">
      <tbody id="contain_comments">
      </tbody>
    </table>
    <div id="del_comment"></div>
  </div>
</div>
</div>

<?php include("modalComments.php");?>

<script type="text/javascript" src="../../lib/js/comments.js" defer></script>
