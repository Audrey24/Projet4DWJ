<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- En-tête de la fenêtre modale-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title col-lg-4 offset-lg-4">Connexion</h4>
        <button type="button" class="close" id="closed" data-dismiss="modal">&times;</button>
      </div>

      <!-- Contenu de la fenêtre modale-->
      <div class="modal-body">
        <!--Formulaire de connexion-->
        <form name="connexion_form" id="connexion_form" method="post" action="Login/signin" novalidate>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Pseudonyme</label>
              <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo1" name="pseudo1"  required data-validation-required-message="Entrer votre pseudo.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mot de passe</label>
              <input type="password" class="form-control" placeholder="Votre mot de passe" id="password1" name="password1" required data-validation-required-message="Entrer votre mot de passe.">
              <p class="help-block text-danger"></p>
            </div>
          </div>


          <div id="success1"></div>
          <input type="submit" class="btn btn-success col-lg-3 col-md-3 col-sm-3" id="btn_submit" value="Valider"/>
          <button type="button" class=" btn btn-info col-lg-6 col-md-6 col-sm-6 offset-lg-2 offset-md-2 offset-sm-2" id="sign_in">Créer votre compte</button>
          <div class="copyright" id="forgetLogin">Mot de passe oublié ?</div>
        </form>


        <!--Formulaire d'inscription-->
        <form name="signin_form" id="signin_form" method="post" action="Login/signup" novalidate>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Pseudonyme</label>
              <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo2" name="pseudo2" required data-validation-required-message="Entrer votre pseudo.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Adresse mail</label>
              <input type="email" class="form-control" placeholder="Adresse Mail" id="email2" name="mail22" required data-validation-required-message="Entrer votre adresse mail..">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mot de passe</label>
              <input type="password" class="form-control" placeholder="Votre mot de passe" id="password2" name="pass22" required data-validation-required-message="Entrer votre mot de passe.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <!--<div class="g-recaptcha" data-sitekey="6LdjZkMUAAAAAMKX1N30r9ALt2tk1o4H7ztK8x98" data-size="invisible" data-badge="inline"> </div>-->

          <div id="success"></div>
          <input type="submit" class="btn btn-success col-lg-12 col-md-12 col-sm-12 g-recaptcha" id="sign_up" value="Créer"/>
        </form>

        <!--Récupération mot de passe-->
        <form name="getLogin" id="getLogin" method="post" action="" novalidate>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <p>Veuillez entrer votre adresse mail afin de récupérer votre mot de passe</p>
              <label>Adresse mail</label>
              <input type="email" class="form-control" placeholder="Adresse Mail" name="mailGetLogin" id="mailGetLogin" required data-validation-required-message="Entrer votre adresse mail..">
              <p class="help-block text-danger"></p>
            </div>
            <div id="sendMail"></div>
            <input type="submit" class="btn btn-success col-lg-12 col-md-12 col-sm-12 g-recaptcha" id="btnGetLogin" value="Valider"/>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="<?php echo  URL; ?>lib/css/login.css" rel="stylesheet">
