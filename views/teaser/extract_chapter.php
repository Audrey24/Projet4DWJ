<link rel="stylesheet" type='text/css'href="<?php echo  URL; ?>lib/css/extract.css">

<div id="extract_book" class="col-lg-12" data-id = "<?php echo $this->data["id"]; ?>">
<div class="cover"><h1 id="extract_title"><?php echo $this->data["title"]; ?></h1></div>
<?php $data = $this->data['content'];

$parts = explode("</p>", $data);
$result = count($parts);
$page = "";
$count = 1;

for ($i=0; $i<$result; $i++) {
    $page .= $parts[$i];
    if (strlen($page) >1800 || $i==$result) {
        echo '<div><div class="page">'. $page . '</div><div class="pagination">' . $count .'</div></div>';
        $page = "";
        $count++;
    }
};
?>

<div class="Extract_end">
  <p id="suite_extract" class="Btnconnexion" data-toggle="modal" data-target="#myModal">Si ce chapitre vous a plu, cliquez pour vous connecter et lire la suite !</p>
</div>
</div>

<script type="text/javascript" src="lib/other/turnjs4/lib/turn.min.js" defer></script>
<script type="text/javascript" src="lib/js/extract_chapter.js" defer></script>
