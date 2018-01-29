<!-- Fenêtre modale -->
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
        <form name="connexion_form" id="connexion_form">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Adresse mail</label>
              <input type="email" class="form-control" placeholder="Votre adresse mail" id="mail1" required data-validation-required-message="Entrer votre adresse mail.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mot de passe</label>
              <input type="password" class="form-control" placeholder="Votre mot de passe" id="password1" required data-validation-required-message="Entrer votre mot de passe.">
              <p class="help-block text-danger"></p>
            </div>
          </div></br>

          <input type="submit" class="btn col-lg-3 col-md-4 col-sm-6" id="btn_submit" value="Valider"/>
          <button type="button" class=" btn col-lg-6 col-md-6 col-sm-6 offset-lg-2 offset-md-1 offset-sm-1" id="sign_in">Créer votre compte</button>
        </form>

        <form name="signin_form" id="signin_form">
          <div class="control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
              <label>Pseudonyme</label>
              <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo" required data-validation-required-message="Entrer votre pseudo.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Adresse mail</label>
              <input type="email" class="form-control" placeholder="Votre adresse mail" id="mail2" required data-validation-required-message="Entrer votre adresse mail.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Mot de passe</label>
              <input type="password" class="form-control" placeholder="Votre mot de passe" id="password2" required data-validation-required-message="Entrer votre mot de passe.">
              <p class="help-block text-danger"></p>
            </div>
          </div></br>

          <input type="submit" class="btn col-lg-4 offset-lg-4" value="Créer"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="signin_form.js"></script>
