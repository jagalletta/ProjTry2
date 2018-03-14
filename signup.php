<?php
// Include DBconnecation file
require_once 'config.php';

// Define variables and initialize with empty values
$firstName = $lastName = $email = $userName = $lang = $password = $confirm_password = "";
$firstName_err = $lastName_err = $email_err = $username_err = $lang_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validate FirstName
    if (empty($_POST["firstName"])) {
        $firstName_err = "Please enter a  firstName.";
    } else {
        $firstName = trim($_POST['firstName']);
    }

    //Validate LasttName
    if (empty(isset($_POST["lastName"]))) {
        $lastName_err = "Please enter a lastName.";
    } else {
        $lastName = trim($_POST['lastName']);
    }
    //Validate email
    if (empty(isset($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    } else {
        $email = trim($_POST['email']);
    }

    // Validate username
    if (empty(isset($_POST["userName"]))) {
        $username_err = "Please enter a userName.";
    } else {
        // Prepare a select statement
        $sql = "SELECT userName FROM users WHERE userName = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["userName"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $userName = trim($_POST["userName"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        //Validate language
        if (empty(isset($_POST["langValue"]))) {
            $lang_err = "Please Select language.";
        } else {
            $lang = trim($_POST['langValue']);
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(isset($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(isset($_POST["confirm_password"]))) {
        $confirm_password_err = 'Please confirm_password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if (empty($firstName_err) && empty($lastName_err) && empty($email_err) && empty($username_err) && empty($lang_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (firstName,lastName,email,userName,language, password) VALUES (?,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_firstname, $param_lastname, $param_email, $param_username, $param_lang, $param_password);

            // Set parameters

            $param_firstname = $firstName;
            $param_lastname = $lastName;
            $param_email = $email;
            $param_username = $userName;
            $param_lang = $lang;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: welcome.html");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }


        // Close statement
        mysqli_stmt_close($stmt);
    }


    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
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
                                <li> <a href="index.html">Home</a> </li>
                                <li> <a href="about.html">About Us</a> </li>
                                <li> <a  href="contact.html">Contact</a> </li>
                                <li><a href="login.php">Login</a> </li>
                                <li> <a href="signup.php">Sign Up</a> </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Sign UP Section -->
        <div id="signup" class="text-center">
            <div class="container">
                <div class="section-title center">
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <form name="signup" id="signupForm" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        <h2>Get Started!</h2> 
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" id="firstName1" name="firstName" class="form-control" value="<?php echo $firstName; ?>" placeholder="First Name*" required="required">
                                    <p class="help-block text-danger"><?php echo $firstName_err; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                                    <input  type="text" id="lastName1" name="lastName" class="form-control" placeholder="Last Name*" required="required"value="<?php echo $lastName; ?>" >
                                    <p class="help-block text-danger"><?php echo $lastName_err; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                    <input type="email" id="email1" name="email" class="form-control" value="<?php echo $email; ?>"placeholder="Email Address*" required="required">
                                    <p class="help-block text-danger"><?php echo $email_err; ?></p>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <input type="text" id="userName1" name="userName" class="form-control" value="<?php echo $userName; ?>" placeholder="@UserName*" required="required">
                                    <p class="help-block text-danger"><?php echo $username_err; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group<?php echo (!empty($lang_err)) ? 'has-error' : ''; ?>">
                                    <select class="col-md-12" name="langValue" class="form-control"value="<?php echo $lang; ?>" placeholder= "Choose a Language">
                                        <p class="help-block text-danger"><?php echo $lang_err; ?></p>
                                        <option value="Lanug">Choose a Language</option>
                                        <option value="AF">Afrikanns</option>
                                        <option value="SQ">Albanian</option>
                                        <option value="AR">Arabic</option>
                                        <option value="HY">Armenian</option>
                                        <option value="EU">Basque</option>
                                        <option value="BN">Bengali</option>
                                        <option value="BG">Bulgarian</option>
                                        <option value="CA">Catalan</option>
                                        <option value="KM">Cambodian</option>
                                        <option value="ZH">Chinese (Mandarin)</option>
                                        <option value="HR">Croation</option>
                                        <option value="CS">Czech</option>
                                        <option value="DA">Danish</option>
                                        <option value="NL">Dutch</option>
                                        <option value="EN">English</option>
                                        <option value="ET">Estonian</option>
                                        <option value="FJ">Fiji</option>
                                        <option value="FI">Finnish</option>
                                        <option value="FR">French</option>
                                        <option value="KA">Georgian</option>
                                        <option value="DE">German</option>
                                        <option value="EL">Greek</option>
                                        <option value="GU">Gujarati</option>
                                        <option value="HE">Hebrew</option>
                                        <option value="HI">Hindi</option>
                                        <option value="HU">Hungarian</option>
                                        <option value="IS">Icelandic</option>
                                        <option value="ID">Indonesian</option>
                                        <option value="GA">Irish</option>
                                        <option value="IT">Italian</option>
                                        <option value="JA">Japanese</option>
                                        <option value="JW">Javanese</option>
                                        <option value="KO">Korean</option>
                                        <option value="LA">Latin</option>
                                        <option value="LV">Latvian</option>
                                        <option value="LT">Lithuanian</option>
                                        <option value="MK">Macedonian</option>
                                        <option value="MS">Malay</option>
                                        <option value="ML">Malayalam</option>
                                        <option value="MT">Maltese</option>
                                        <option value="MI">Maori</option>
                                        <option value="MR">Marathi</option>
                                        <option value="MN">Mongolian</option>
                                        <option value="NE">Nepali</option>
                                        <option value="NO">Norwegian</option>
                                        <option value="FA">Persian</option>
                                        <option value="PL">Polish</option>
                                        <option value="PT">Portuguese</option>
                                        <option value="PA">Punjabi</option>
                                        <option value="QU">Quechua</option>
                                        <option value="RO">Romanian</option>
                                        <option value="RU">Russian</option>
                                        <option value="SM">Samoan</option>
                                        <option value="SR">Serbian</option>
                                        <option value="SK">Slovak</option>
                                        <option value="SL">Slovenian</option>
                                        <option value="ES">Spanish</option>
                                        <option value="SW">Swahili</option>
                                        <option value="SV">Swedish </option>
                                        <option value="TA">Tamil</option>
                                        <option value="TT">Tatar</option>
                                        <option value="TE">Telugu</option>
                                        <option value="TH">Thai</option>
                                        <option value="BO">Tibetan</option>
                                        <option value="TO">Tonga</option>
                                        <option value="TR">Turkish</option>
                                        <option value="UK">Ukranian</option>
                                        <option value="UR">Urdu</option>
                                        <option value="UZ">Uzbek</option>
                                        <option value="VI">Vietnamese</option>
                                        <option value="CY">Welsh</option>
                                        <option value="XH">Xhosa</option>
                                    </select>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <input type="password" id="password1" name="password" class="form-control" value="<?php echo $password; ?>"placeholder="Password*" required="required">
                                    <p class="help-block text-danger"><?php echo $password_err; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>"">
                                    <input  type="password" id="confirm_password1" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password*" required="required" >
                                    <p class="help-block text-danger"><?php echo $confirm_password_err; ?></p>
                                </div>
                            </div>
                        </div>

                        <div id="success"></div>
                        <button type="submit" class="btn btn-default btn-lg">Sign Up</button>
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
            </div>   
        </footer>
    </body>
</html>