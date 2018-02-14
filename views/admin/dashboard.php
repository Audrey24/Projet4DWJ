<div class="container">
  <div class="row">
    <div class="nav-side-menu col-lg-3">
      <div class="brand">Menu</div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out">
                <li data-toggle="collapse" data-target="#news" class="collapsed active">
                  <a href="#"><i class="fa fa-pencil fa-lg"></i>Articles</a><span id="fleche1" class="fa fa-angle-down fa-lg"></span>
                </li>

                    <ul class="sub-menu collapse" id="news">
                      <li class="write">Rédiger</li>
                      <li>Modifier</li>
                      <li>Corbeille</li>
                      <li>Supprimer</li>
                    </ul>

                <li data-toggle="collapse" data-target="#chapters" class="collapsed">
                  <a href="#"><i class="fa fa-book fa-lg"></i>Chapitres </a><span id="fleche2" class="fa fa-angle-down fa-lg"></span>
                </li>
                    <ul class="sub-menu collapse" id="chapters">
                      <li class="write">Rédiger</li>
                      <li>Modifier</li>
                      <li>Corbeille</li>
                      <li>Supprimer</li>
                    </ul>

                <li><i class="fa fa-calendar fa-lg"></i> Publication différée</li>
                <li><i class="fa fa-trash fa-lg"></i> Corbeille</li>
            </ul>
        </div>
      </div>

      <div id="text" class="col-lg-7 offset-lg-1">
        <div class="container">
          <div class="row">
            <h3 class="col-lg-5" >Editeur de texte</h3>
            <button type="button" class="btn col-lg-1 offset-lg-6 closed">&times;</button>
          </div>
        </div>
      </br>
        <textarea></textarea>
      </br>
        <button type="button" class=" btn btn-success col-lg-12 col-md-12 col-sm-12">Valider</button>
      </div>
    </div>
  </div>
