<div class="container" id="contactAutor">
  <div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
      <p>Pour me contacter ? Remplissez ce formulaire et je vous répondrais dans les meilleurs délais !</p>
      <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
      <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
      <!-- To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
      <form name="sentMessage" id="contactForm" novalidate>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>Nom</label>
            <input type="text" class="form-control" placeholder="Nom" id="name" required data-validation-required-message="Entrer votre nom.">
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>Adresse mail</label>
            <input type="email" class="form-control" placeholder="Adresse Mail" id="email" required data-validation-required-message="Entrer votre adresse.">
            <p class="help-block text-danger"></p>
          </div>
        </div>

        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label>Message</label>
            <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Entrer votre message."></textarea>
            <p class="help-block text-danger"></p>
          </div>
        </div>
        <br>
        <div id="success"></div>
        <div class="form-group">
          <button type="submit" class="btn btn-success col-lg-2 col-md-4 offset-lg-5 offset-md-4" id="sendMessageButton">Envoyer</button>
        </div>
      </form>
    </div>
  </div>
</div>
