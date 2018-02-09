
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
              <input type="test" class="form-control" placeholder="Votre pseudo" id="pseudo1" name="pseudo1"  required data-validation-required-message="Entrer votre pseudo.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mot de passe</label>
              <input type="password" class="form-control" placeholder="Votre mot de passe" id="password1" name="password1" required data-validation-required-message="Entrer votre mot de passe.">
              <p class="help-block text-danger"></p>
            </div>
          </div></br>

          <input type="submit" class="btn col-lg-3 col-md-4 col-sm-6" id="btn_submit" value="Valider"/>
          <button type="button" class=" btn col-lg-6 col-md-6 col-sm-6 offset-lg-2 offset-md-1 offset-sm-1" id="sign_in">Créer votre compte</button>
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
          </div></br>

          <div id="success"></div>
          <input type="submit" class="btn col-lg-4 offset-lg-4"  id="sign_up" value="Créer"/>

          <!--<button class="g-recaptcha" data-sitekey="6LdjZkMUAAAAAMKX1N30r9ALt2tk1o4H7ztK8x98" data-callback="onSubmit">Submit</button>-->
        </form>
      </div>
    </div>
  </div>
</div>
