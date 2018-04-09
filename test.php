<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
// If you are using Composer (recommended)
//require 'vendor/autoload.php';
// If you are not using Composer
require("~/stack/sendgrid-php/sendgrid-php.php");

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];

$from = new SendGrid\Email($name,$email_address);
$subject = "Musicbass message from ".$name;
$to = new SendGrid\Email("John Galletta", "jagalletta@gmail.com");
$content = new SendGrid\Content("text/plain", $message);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
print_r($response->headers());
echo $response->body();
?>