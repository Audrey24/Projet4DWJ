<?php
Session::init();
Session::set('current', $this->data['id']);
 ?>

<div id="book" class="col-lg-12" data-id="<?php echo $this->data['id']; ?>">
<div><h1><?php echo $this->data['title']; ?></h1></div>
<div><?php echo $this->data['content'];?></div>
</div>

<?php $next = $this->data['id']+1;
$prev = $this->data['id']-1; ?>



<div id="controls" class="col-lg-4 offset-lg-5">
    <button type="button" class="btn" id="prev"><a href="<?php echo URL .'Current_chapter/read/' . $prev; ?>"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i></a></button>
    <button type="button" class="btn" id="next"><a href="<?php echo URL .'Current_chapter/read/' . $next; ?>"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a></button>
</div>

<hr>

<div class="container">
  <div class="row">
      <div class="col-lg-3 col-sm-12 offset-lg-1 control-group">
        <?php if (!empty(Session::get('pseudo'))) {
    ?>
        <div class="form-group floating-label-form-group controls">
          <label>Commenter</label>
          <textarea placeholder="Votre commentaire" id="commentChapter" name ="commentChapter" required data-validation-required-message="Veuillez écrire un commentaire."></textarea>
        </div>
        <div id="commentChp"></div></br>
        <button type="submit" class="btn btn-success col-lg-12 col-md-12" id="commenter_chap">Commenter</button>
        <?php
} else {
        ?> <div class="connexionMsg">Vous devez être connecté pour pouvoir laisser un commentaire !</div></br>
        <button class="btn btn-info col-lg-12 col-md-12" data-toggle="modal" data-target="#myModal">Connexion</button><?php
    } ?>
      </div></br>

      <div class="col-lg-7 col-sm-12 offset-lg-1 control-group">
        <p id='lastComments'>Derniers commentaires</p>
        <table class="table table-sm">
          <tbody id="contain_commentsChap">
          </tbody>
        </table>
        <div id="dislike_commentchap"></div>
      </div>
    </div>
</div>

<?php include("modalCommentChapter.php");?>

<script type="text/javascript" src="../../lib/js/comments_chapter.js" defer></script>

<!--<script type="text/javascript" src="lib/themeAdd/turn.min.js" defer></script>-->
<!--<script type="text/javascript" src="lib/themeAdd/readbook.js" defer></script>-->
