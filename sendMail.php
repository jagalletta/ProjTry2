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
    //javascriptalert sent
    //echo "Your message has been sent to John!";
    echo '<script type="text/javascript">alert("Your message has been sent!"); </script>';
}else{
    //"Something went wrong.  Please make sure the form is complete, or send me a message at john.a.galletta@drexel.edu."
    echo "Something went wrong.  Please make sure the form is complete, or send me a message at john.a.galletta@drexel.edu.";
}
//print_r($response->headers());
//echo $response->body();
?>