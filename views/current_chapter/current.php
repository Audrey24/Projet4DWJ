<?php
//Utilisation du JS car la redirection buguait car le header été déjà chargé donc impossible à modifier.
if (!empty(Session::get('current'))) {
    echo '<script type="text/javascript">
           window.location = "'. URL . 'Current_chapter/read/' . Session::get('current') .'"
      </script>';
} else {
    echo " Il semble que vous n'avez pas de lecture en cours";
}
