<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MusicBass</title>
        <meta name="description" content="">
        <meta name="author" content="">


        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300'>

    </head>
    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
        <!-- Header -->
        <header id="header">
            <div id="nav">
                <nav class="navbar navbar-custom">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
                        </div>
                        <div class="collapse navbar-collapse navbar-main-collapse">
                            <ul class="nav navbar-nav">
                                <li> <a href="index.php">Home</a> </li>
                                <li> <a href="about.php">About Us</a> </li>
                                <li> <a href="contact.php">Contact</a> </li>
                                <?php
                                if (!isset($_SESSION['userName']) || empty($_SESSION['userName'])) {
                                    ?>
                                    <li> <a id="nav4" href="login.php">Login</a> </li>
                                    <li> <a id="nav4" href="signup.php">Sign Up</a> </li>
                                    <?php
                                } else {
                                    ?>
                                    <li> <a href="logout.php">Sign Out</a> </li>
                                    <!-- wrapped username in an <a> tag to get css formatting of <a> objects -->
                                    <li><a href="dashboard.php">Hi,<b><?php echo htmlspecialchars($_SESSION['userName']); ?></b></a> </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Contact Section -->
        <div id="contact" class="text-center">
            <div class="container">
                <div class="section-title center">
                    <h2>Get In Touch</h2>
                    <hr>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <form action="sendMail.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Message" required></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div id="success"></div>
                        <button type="submit" class="btn btn-default btn-lg" onclick="" >Send Message</button>
                    </form>    
                    <div class="social">
                        <ul>
                            <li><a href="https://www.facebook.com/drexeluniv/"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/DrexelUniv?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
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
