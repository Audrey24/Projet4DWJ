<?php Session::init(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" lang="fr">
    <title>Jean Rochefort, blog d'éciture</title>
    <link href="<?php echo  URL; ?>lib/themeAdd/css/clean-blog.min.css" rel="stylesheet">
    <link href="<?php echo  URL; ?>lib/themeAdd/css/clean-blog.css" rel="stylesheet">
    <link href="<?php echo  URL; ?>lib/themeAdd/dep/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo  URL; ?>lib/themeAdd/dep/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  </head>
  </head>
  <body>
    <div id="header">
      <!-- Page Header -->
      <header class="masthead" style="background-image: url('<?php echo URL . $backgroundImg; ?>')">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
              <div class="site-heading">
                <h1>Jean Forteroche</h1>
                <span class="subheading">Blog d'un écrivain</span>
              </div>
            </div>
          </div>
        </div>
      </header>
    </div>


    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <i class="fa fa-book"></i>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="Home.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="About.php">Qui suis-je ?</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="Contact.php" >Contact</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="Last_chapters.php">Derniers chapitres</a>
            </li>


            <?php
            if (!empty(Session::get('pseudo'))) {
                ?>

            <li class="nav-item">
              <a class="nav-link" href="Current_chapter.php">Lecture en cours</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="Login/disconnect">Déconnexion</a>
            </li>
             <?php
            } else {
                ?>
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal" id="connexion">Connexion</a>
            </li>
            <?php
            } ?>

            <?php
            if (!empty(Session::get('pseudo')) && (Session::get('role')) == 'admin') {
                ?>
            <li class="nav-item">
              <a class="nav-link" href="Admin.php">Admin</a>
            </li>
            <?php
            } ?>

          </ul>
        </div>
      </div>
    </nav>


    <?php include('login/connexionform.php');?>

    <div id="content"> </div>
