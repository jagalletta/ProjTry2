<?php	
$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
	
$to = 'jag83@drexel.edu'; 
$email_subject = "Website Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: noreply@musicbass.com\n"; 
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
echo "<script>
alert('message successfully sent');
window.location.href='index.html';
</script>";
?>