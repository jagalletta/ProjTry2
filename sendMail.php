<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
// If you are using Composer (recommended)
//require 'vendor/autoload.php';
// If you are not using Composer
require("/opt/bitnami/sendgrid-php/sendgrid-php.php");
require(".setMailKey.php");
//require('getenv');

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$from = new SendGrid\Email($name,$email_address);
$subject = "Musicbass message from ".$name;
$to = new SendGrid\Email("John Galletta", "jagalletta@gmail.com");
$content = new SendGrid\Content("text/plain", $message);
$mail = new SendGrid\Mail($from, $subject, $to, $content); 
$apiKey = getenv('SENDGRID_API_KEY',true) ;
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
if ($response->statusCode() == 202){
    echo '<script type="text/javascript">alert("Your message has been sent!"); window.location = "https://www.musicbass.live";</script>';
}else{
    echo '<script type="text/javascript">alert("Something went wrong.  Please try again later or contact me at john.a.galletta@drexel.edu."); window.location = "https://www.musicbass.live/contact.php";</script>';
}
//print_r($response->headers());
//echo $response->body();
?>