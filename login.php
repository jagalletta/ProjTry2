<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$userName = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["userName"]))) {
        $userName_err = 'Please enter username.';
    } else {
        $userName = trim($_POST["userName"]);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT userName, password, language FROM users WHERE userName  = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $userName;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $userName, $hashed_password, $language);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            /* Password is correct, so start a new session and
                              save the username to the session */
                            session_start();
                            $_SESSION['userName'] = $userName;
                            $_SESSION['language'] = $language;
                            header("location: welcome1.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In</title>
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
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
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
                    <form name="login" id="loginForm" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        <h2>Welcome Back!</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" id="userName1" name="userName" class="form-control" value="<?php echo $userName; ?>" placeholder="@UserName*" required="required">
                                    <p class="help-block text-danger"><?php echo $username_err; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <input type="password" id="password1" name="password" class="form-control" value="<?php echo $password; ?>"placeholder="Password*" required="required">
                                    <p class="help-block text-danger"><?php echo $password_err; ?></p>
                                </div>
                            </div>
                        </div>

                        <p class="forgot"><a href="forgetPW.php">Forgot Password?</a></p>
                        <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
                        <div id="success"></div>
                        <button type="submit" class="btn btn-default btn-lg">Log In</button>
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