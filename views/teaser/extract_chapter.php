<link rel="stylesheet" type='text/css'href="<?php echo  URL; ?>lib/css/extract.css">

<div id="extract_book" class="col-lg-12" data-id = "<?php echo $this->data["id"]; ?>">
<div class="cover"><h1 id="extract_title"><?php echo $this->data["title"]; ?></h1></div>
<?php $data = $this->data['content'];
echo '<div class="page">'. $data . '</div>' ?>


<div class="Extract_end">
  <p id="suite_extract" data-toggle="modal" data-target="#myModal">Si ce chapitre vous a plu, cliquez pour vous connecter et lire la suite !</p>
</div>
</div>

<script type="text/javascript" src="lib/other/turnjs4/lib/turn.min.js" defer></script>
<script type="text/javascript" src="lib/js/extract_chapter.js" defer></script>
