<div class="container">
  <div class="row">
    <div class="nav-side-menu col-lg-3">
      <div class="brand">Menu</div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out">
                <li data-toggle="collapse" data-target="#news" class="collapsed active">
                  <i class="fa fa-pencil fa-lg"></i> Editeur de texte</li>
                    <ul class="sub-menu collapse" id="news">
                      <li class='updateCol2' data-file="write" id="btn_write">Rédiger</li>
                    </ul>

                  <li data-toggle="collapse" data-target="#edit" class="collapsed active">
                      <i class="fa fa-edit fa-lg"></i>Modifier/Supprimer</li>
                        <ul class="sub-menu collapse" id="edit">
                          <li class='updateCol2' data-file="edit" data-type="Article">Articles</li>
                          <li class='updateCol2' data-file="edit" data-type="Chapitre">Chapitres</li>
                          <li class='updateCol2' data-file="edit" data-type="Brouillon">Brouillons</li>
                        </ul>

                <li><i class="fa fa-comments fa-lg"></i></i> Commentaires</li>
            </ul>
        </div>
      </div>

      <div id="colonne2" class="col-lg-9"></div>

  </div>

  <script src="<?php echo  URL; ?>lib/js/admin_dashboard.js" defer></script>
