window.onload = function () {

  var signIn = document.getElementById("sign_in");
  var connexionForm = document.getElementById("connexion_form");
  document.getElementById("signin_form").style.display = "none";
  var closed = document.getElementById("closed");

  signIn.addEventListener('click', function() {
     connexionForm.style.display = "none";
     document.getElementById("signin_form").style.display = "block";
  });

  closed.addEventListener('click', function() {
    annuler();
  });

  function annuler() {
    connexionForm.style.display = "block";
     document.getElementById("signin_form").style.display = "none";
  }

};
