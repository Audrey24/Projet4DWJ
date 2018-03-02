<?php
  Session::init();
  Session::set('current', $this->data['id']);
 ?>
<link href="<?php echo  URL; ?>lib/css/book.css" rel="stylesheet" type='text/css'></link>

<div id="flipbook" class="col-lg-12" data-id="<?php echo $this->data['id']; ?>">
<div class="cover"><h1 id="ChapTitle"><?php echo $this->data["title"]; ?></h1></div>
<?php $data = $this->data['content'];
//echo $data;
//decoupage du chapitre en pages

$parts = explode("</p>", $data);
//echo(strlen($parts[0]));
$result = count($parts);
$page = "";
$count = 1;



for ($i=0; $i<$result; $i++) {
    $page .= $parts[$i];
    if (strlen($page) >2000 || $i==$result) {
        echo '<div><div class="page">'. $page . '</div><div class="pagination">' . $count .'</div></div>';
        $page = "";
        $count++;
    }
};
?>
<div class="coverEnd">
  <p id="suite">A suivre ...</p>
  <p id="comEnd">Si ce chapitre vous a plu, n'hésitez pas à laisser un commentaire sur la page suivante ! </p>
</div>

<div class="container">
      <div class=" control-group">
        <?php if (!empty(Session::get('pseudo'))) {
    ?>
        <div class="form-group floating-label-form-group controls">
          <label>Commenter</label>
          <textarea placeholder="Votre commentaire" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="commentChapter" name ="commentChapter" required data-validation-required-message="Veuillez écrire un commentaire."></textarea>
        </div>
        <div id="commentChp"></div></br>
        <button type="submit" class="btn btn-success col-lg-12 col-md-12 col-sm-12 col-xs-12" id="commenter_chap">Commenter</button>
        <?php
} else {
        ?> <div class="connexionMsg">Vous devez être connecté pour pouvoir laisser un commentaire !</div></br>
        <button class="btn btn-info col-lg-12 col-md-12" data-toggle="modal" data-target="#myModal">Connexion</button><?php
    } ?>
      </div></br>

      <div class="control-group">
        <p id='lastComments'>Derniers commentaires</p>
        <table class="table table-sm">
          <tbody id="contain_commentsChap">
          </tbody>
        </table>
        <div id="dislike_commentchap"></div>
      </div>
    </div>
</div></br>

<div id="controls">
    <button type="button" class="btn btn-info col-lg-2 col-md-3 col-sm-3 col-xs-3 offset-lg-3 offset-md-2 offset-sm-2 offset-xs-2" id="prev"><a id="prevLink">Chapitre précédent</a></button>
    <button type="button" class="btn btn-info col-lg-2 col-md-3 col-sm-3 col-xs-3 offset-lg-2 offset-md-2 offset-sm-2 offset-xs-2" id="next"><a id="nextLink">Chapitre suivant</a></button>
</div>

<?php include("modalCommentChapter.php");?>

<script type="text/javascript" src="../../lib/js/comments_chapter.js" defer></script>
<!--<script type="text/javascript" src="../../lib/themeAdd/turn.min.js" defer></script>-->
<script type="text/javascript" src="../../lib/other/turnjs4/lib/turn.min.js" defer></script>
<script type="text/javascript" src="../../lib/js/readingbook.js" defer></script>
<script type="text/javascript" src="../../lib/js/book.js" defer></script>

<!--<script type="text/javascript" src="../../lib/themeAdd/readbook.js" defer></script>-->
