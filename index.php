<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (isset($_SESSION['userName']) && !empty($_SESSION['userName'])) {
    header("location: welcome.php");
    exit;
}
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
        <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

        <!-- Stylesheet
            ================================================== -->
        <link rel="stylesheet" type="text/css"  href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/nivo-lightbox.css">
        <link rel="stylesheet" type="text/css" href="css/nivo-lightbox/default.css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
        <script>

            //list of elements with name 'inputBox' (all inputs on form)
            var input_list = document.getElementsByName('inputBox');
            var resultsPlaceholderHTML = "";

            // to keep form from opening a new page
            function preventSubmission() {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    showResults();
                }
            }
            //simple validation that form has content in at least one inputBox
            function validateFields() {
                var validated = false;
                for (var i = 0; i < input_list.length; i++) {
                    //loop through array of inputs in input_list defined at top of page.
                    if (input_list[i].value.toString().trim() != "") {
                        validated = true;
                    }
                }
                return validated;
            }
            function showResults() {
                var input_list = document.getElementsByName('inputBox');
                var results_area = document.getElementById('results');
                if (validateFields() == true) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function ()
                    {
                        if (xmlhttp.readyState === 4 && this.status === 200) {
                            //results_area.style = resultsStyle;
                            results_area.innerHTML = xmlhttp.responseText;
                            document.getElementById('search').scrollIntoView();
                        }
                    }
                    //var age = document.getElementById("age").value.toString().trim();
                    var searchString = "";
                    var attribute = "";
                    var value;
                    for (var i = 0; i < input_list.length; i++) {
                        attribute = input_list[i].getAttribute('id').toString();
                        value = input_list[i].value.toString();
                        searchString += attribute + '=' + value;
                        if (i < input_list.length - 1) {
                            searchString += "&";
                        }
                        //alert(input_list[i].value.toString().trim());
                    }
                    //alert(searchString);
                    xmlhttp.open("GET", "artists.php?" + searchString, false);
                    xmlhttp.send();
                } else {
                    if (document.getElementById("price").value < 0) {
                        negativeResults();
                    } else {
                        resetResults();
                    }
                }
            }
            function clearForm() {
                var input_list = document.getElementsByName('inputBox');
                for (var i = 0; i < input_list.length; i++) {
                    input_list[i].value = "";
                }
                resetResults();
            }
            function resetResults() {
                var results_area = document.getElementById('results');
                resultsPlaceholderStyle = "margin-top:285px;  margin-bottom:60px; text-align:center;";
                //results_area.style = resultsPlaceholderStyle;
                results_area.innerHTML = resultsPlaceholderHTML;
            }
            function startDictation() { //from Google API Example at
                //Check if browser is capable of this function
                if (window.hasOwnProperty('webkitSpeechRecognition')) {
                    
                    //Creat new instance of the speech recognition object
                    var recognition = new webkitSpeechRecognition();
                    
                    //set continuous to false so recognition returns the first phrase detected and/or times out
                    recognition.continuous = false;
                    
                    //if was set to continuous, the recognition object would be able to return updates to what it's hearing
                    recognition.interimResults = false;
                    
                    //set default language - this is where we can set to user language once user is logged in.
                    recognition.lang = "en-US";
                    
                    //start listening
                    recognition.start();
                    
                    //change microphone gif from static image to listening mic
                    document.getElementById("micImg").src = "img/mic-animate.gif";
                    
                    //this is where we define what the recoognition does when it returns a result - notice it is an inline function
                    recognition.onresult = function (e) {
                        
                        //here we set the value of the searchbox named artist to the transcript result.  
                        //the [0][0] here references the first location in a 2d array
                        //if we used continuous recognition, there may be other values such as [0][1] or [0][2] which you may loop through
                        document.getElementById('artist').value
                                = e.results[0][0].transcript;
                        
                        //stop listening
                        recognition.stop();
                        
                        //change mic image back to static
                        document.getElementById('micImg').src = "img/mic.gif";
                        
                        //call search function
                        showResults();
                    };
                    //error catching here
                    recognition.onerror = function (e) {
                        
                        //stop listening
                        recognition.stop();
                        
                        //change mic image to static
                        document.getElementById('micImg').src = "img/mic.gif";
                    }
                    
                } else {
                    //error message if browser is not compatible
                    alert("Webkit speech recognition is not supported by this browser.");
                }
            }
        </script>
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
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-main-collapse">
                            <ul class="nav navbar-nav">
                                <li> <a href="index.php">Home</a> </li>
                                <li> <a  href="about.php">About Us</a> </li>
                                <li> <a  href="contact.php">Contact</a> </li>
                                <li><a href="login.php">Login</a> </li>
                                <li> <a href="signup.php">Sign Up</a> </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="intro">
                <div class="container">
                    <div class="row">
                        <div class="intro-text">
                            <h1>MusicBass</h1>
                            <p>Search Last.fm Similar Artists </p>
                            <img src='img/3906-last-fm-icon-vector-icon-vector-eps.png' height=40 alt="last.fm logo"></br>
                            <h3>Enter search criteria to begin...</h3>
                            <form class='w3-light-grey' style='margin-bottom:15px;' name="searchForm">
                                <div style="text-align: center;">
                                    <table style="margin-left:auto; margin-right:auto;" width ="800">

                                        <tr>
                                            <td colspan="2"><h4 class='w3-light-grey shadowedtext' style='margin-left: 15px; margin-right:15px;'><input type="text" style="padding-left:10px; width: 500px;margin-left:20px;  border:0px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" name="inputBox" id="artist" placeholder="Search artists or activate voice search" onkeydown="preventSubmission();"><img id="micImg" style="margin-left:5px" onclick="startDictation()" src="img/mic.gif" alt="mic.gif"/> </h4></td>
                                        </tr>
                                        <tr>
                                            <td><input class='btn btn-default btn-lg' style='margin-right:15px;' type="button" value="Clear Criteria" onclick="clearForm();"><input class='btn btn-default btn-lg' style='margin-left:15px;' type="button" value="Search last.fm" onclick="showResults();"></td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- results Section -->
        <div id="search" style="height:75px"></div>
        <div id="results" class="text-center">
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