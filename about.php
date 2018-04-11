<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>About Us</title>


        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css"  href="css/style.css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
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
        <div id="about">
            <div class="container">
                <div class="section-title text-center center">
                    <h2>About Us</h2>
                    <hr>
                </div>
                <div class="padded-box row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <img class="card-img-top" src="img/john.jpg">
                            <div class="card-body">
                                <p class="card-text">John Galletta</p>
                                <div class="social">
                                    <a href="https://www.facebook.com/john.a.galletta" style="font-size:36px;" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp&nbsp&nbsp&nbsp
                                    <a href="https://twitter.com/JGalletta" style="font-size:36px;"target="_blank"><i class="fa fa-twitter"></i></a>&nbsp&nbsp&nbsp&nbsp
                                    <a href="https://www.linkedin.com/in/jagalletta/" style="font-size:36px;"target="_blank"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <img class="card-img-top" src="img/mario.jpg">
                            <div class="card-body">
                                <p class="card-text">Mario Saint-Fleur</p>
                                <a href="https://m.facebook.com/mario.stfleur?refid=8" style="font-size:36px;"target="_blank"><i class="fa fa-facebook"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://mobile.twitter.com/Mario_bros18" style="font-size:36px;" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://www.linkedin.com/in/mario-saint-fleur-94bb7210a/" style="font-size:36px;" target="_blank"><i class="fa fa-linkedin"></i></a>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center">
                            <img class="card-img-top" src="img/Abeer.jpg">
                            <div class="card-body">
                                <p class="card-text">Abeer Almahyawi</p>
                                <a href="https://www.facebook.com/drexeluniv/" style="font-size:36px;" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://twitter.com/abeer_aabeer" style="font-size:36px;" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://www.linkedin.com" style="font-size:36px;" target="_blank"><i class="fa fa-linkedin"></i></a>
                                <br/><br/><br/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center">
                            <img class="card-img-top" src="img/muna.jpeg" >
                            <div class="card-body">
                                <p class="card-text">Mona Albalawi</p>
                                <a href="https://www.facebook.com/drexeluniv/" style="font-size:36px;" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://twitter.com/DrexelUniv?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" style="font-size:36px;" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp&nbsp&nbsp&nbsp
                                <a href="https://www.linkedin.com/in/mona-albalawi-412197145" style="font-size:36px;" target="_blank"><i class="fa fa-linkedin"></i></a>

                            </div>
                        </div>
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