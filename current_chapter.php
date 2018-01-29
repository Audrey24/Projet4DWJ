<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="vendor/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="vendor/css/clean-blog.min.css" rel="stylesheet">
    <link href="vendor/css/clean-blog.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <?php include("menu.php");?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('images/chapitre.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <span class="subheading">Lecture</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div id="book">
	     <div class="cover">
         <h1>Jean Forteroche</h1>
         <p>Nouveau livre</p>
       </div>
    </div>
  </br>
    <div id="controls" class="col-lg-4 offset-lg-4" >
	      <label for="page-number">Page:</label><input type="text" size="3" id="page-number"> sur <span id="number-pages"></span></br>
	      <button type="button" class="btn btn-outline-secondary" id ="prev"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></button>
        <button type="button" class="btn btn-outline-secondary" id="next"><i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i></button>
    </div>

    <!-- Footer -->
    <?php include("footer.php");?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/vendor/jquery/jquery.min.js"></script>
    <script src="vendor/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="vendor/js/clean-blog.min.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="vendor/turn.min.js"></script>
    <script type="text/javascript" src="readbook.js"></script>

  </body>

</html>
