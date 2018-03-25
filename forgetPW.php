<?php

error_reporting(0);
if($_POST['submit']=='Send')
{
//keep it inside
$email=$_POST['email'];
$code = $_GET['activation_code'];
$con=mysqli_connect("localhost","root","","ProjectDB");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$query = mysqli_query($con,"select * from users where email='$email'")
or die(mysqli_error($con)); 

 if (mysqli_num_rows ($query)==1) 
 {
$code=rand(100,999);
$message="You activation link is: http://localhost/ProjTry2//resetpass.php?email=$email&code=$code";
mail($email, "Password reset", $message);
echo "<script>
alert('message successfully sent');
window.location.href='index.html';
</script>";;
$query2 = mysqli_query($con,"update users set activation_code='$code' where email='$email' ")
or die(mysqli_error($con)); 
}
else
{
echo 'No user exist with this email id';

}}

//// Include config file
//require_once 'config.php';
//
//
//error_reporting(0);
//if($_POST['submit']=='Send')
//{
////keep it inside
//$email=$_POST['email'];
//$code = $_GET['activation_code'];
//$con=mysqli_connect("Localhost","root","","ProjectDB");
//// Check connection
//if (mysqli_connect_errno())
//  {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
//  }
//$query = mysqli_query($con,"select * from users where email='$email'")
//or die(mysqli_error($con)); 
//
// if (mysqli_num_rows ($query)==1) 
// {
//$code=rand(100,999);
//$message="You activation link is: http://bing.fun2pk.com/resetpass.php?email=$email&code=$code";
//$headers = "From: noreply@musicbass.com\n"; 
//mail($email,"rest Password", $message);
//echo "<script>
//alert('message successfully sent');
//window.location.href='index.html';
//</script>";
//$query2 = mysqli_query($con,"update users set activation_code='$code' where email='$email' ")
//or die(mysqli_error($con)); 
//}
//else
//{
//echo 'No user exist with this email id';
//
//}}

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forget Password</title>
        <meta name="description" content="">
        <meta name="author" content="">


        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

        <!-- Stylesheet
            ================================================== -->
        <link rel="stylesheet" type="text/css"  href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
        <!-- Header -->
        <header id="header">
            <div id="nav">
                <nav class="navbar navbar-custom">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-main-collapse">
                            <ul class="nav navbar-nav">
                                <li> <a  href="index.html">Home</a> </li>
                                <li> <a  href="about.html">About Us</a> </li>
                                <li> <a href="contact.html">Contact</a> </li>
                                <li><a  href="login.php">Login</a> </li>
                                <li> <a href="signup.php">Sign Up</a> </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Login Section -->
        <div id="login" class="text-center">
            <div class="container">
                <div class="section-title center">
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <form name="login" id="forgetPWForm" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        <h2>Forget Password!</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" id="email1" name="email" class="form-control" value="<?php echo $userName; ?>" placeholder="Enter Email ID*" required="required">
                                    <p class="help-block text-danger"><?php echo $username_err; ?></p>
                                </div>
                            </div>
                        </div>
                        <div id="success"></div>
                        <button type="submit" class="btn btn-default btn-lg" name="submit" value="Send">Forget Password</button>
                    </form>    
                </div>
            </div>
        </div>
        <footer id="footer">
            <div id="nav">
                <div class="navbar-fixed-bottom">
                    <nav class="navbar navbar-custom">
                        <div class="container">
                            <p align="center">Copyright &copy; 2018 Team 4</p>
                        </div>
                    </nav>    
                </div>   
        </footer>
    </body>
</html>