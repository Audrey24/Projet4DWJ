<?php
// Check for empty fields
if (empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Pas d'arguments fournis !";
    return false;
}
$recipient = $_POST['recipient'];

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));

$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$to = $recipient; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Message de :  $name";
$email_body = "Vous avez reçu un message du formulaire de contact de votre blog.\n\n"."Voici les détails:\n\nNom: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: noreply@yprojetsdwjguilloux.ovh\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";
mail($to, $email_subject, $email_body, $headers);
return true;
