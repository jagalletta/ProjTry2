<?php
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['userName']) || empty($_SESSION['userName'])) {
    header("location: login.php");
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
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
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
                                <li> <a href="welcome1.php">Home</a> </li>
                                <li> <a href="about.html">About Us</a> </li>
                                <li> <a href="contact.html">Contact</a> </li>
                                <li> <a href="logout.php">Sign Out</a> </li>
                                <!-- wrapped username in an <a> tag to get css formatting of <a> objects -->
                                <li><a href="dashboard.php">Hi,<b><?php echo htmlspecialchars($_SESSION['userName']); ?></b></a> </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <div id="search" style="height:75px"></div>
        <div class="">
            <?php
            // Include DBconnection file
            require_once 'config.php';
            $link->set_charset('utf8');
            // API method is hardcoded for now, but can use a $_GET from HTML page depending on requested functionality.
            $method = "artist.getsimilar";

            // TODO Change parameters and get methods to match last.fm parameters.
            $artist = "";
            $userName = "";
            if (isset($_SESSION['userName'])) {
                $userName = $_SESSION['userName'];
            }


            //initialize curl and set return transfer option
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            //build query array to contain query parameters
            $query = array(
                "api_key" => "01d38e8138fa6072cd679bd0fe45b13f",
                "format" => "json",
            );

            //add $_GET request parameters to query
            $query['method'] = $method;
            $query['artist'] = $artist;

            //set curl URL to API url + query
            curl_setopt($curl, CURLOPT_URL, "http://ws.audioscrobbler.com/2.0/" . "?" . http_build_query($query)
            );

            //store $result of curl execution as decoded json object
            $result = json_decode(curl_exec($curl));


            //create array $artists to store similarartists array from json $result
            //this line may create error if $result is empty
            $count = 0;
            if (isset($result->similarartists)) {
                $artists = $result->similarartists;

                //initialize an accumulator variable for artist count array
                //loop through $artists array and accumulate count
                if (count($artists->artist) != 0) {
                    foreach ($artists->artist as $artist) {
                        ++$count;
                    }
                }
            }

            // $array = array();
            // $q = mysql_query("SELECT Top 3 searchParameter FROM search WHERE userName = ? ORDER By created_at desc limit 3");
            // while($r = mysql_fetch_assoc($q)){
            //     array['searchParameter'] = $row['searchParameter'];
            // }
            // return $array;

            $sql = "SELECT searchParameter FROM search WHERE userName = ? ORDER By created_at desc limit 3";
            ///begin paste

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = $_SESSION['userName'];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $searchParameter);
                        while ($row = mysqli_stmt_fetch($stmt)) {
                            echo "<table class='special' style='margin-left:auto; margin-right:auto; margin-bottom:15px'>";
                            echo "<h1 style='text-align:center;'> Because you searched for " . $searchParameter . ":</h1></br>";
//----results for each parameter
                            //initialize curl and set return transfer option
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                            //build query array to contain query parameters
                            $query = array(
                                "api_key" => "01d38e8138fa6072cd679bd0fe45b13f",
                                "format" => "json",
                            );

                            //add $_GET request parameters to query
                            $query['method'] = $method;
                            $query['artist'] = $searchParameter;

                            //set curl URL to API url + query
                            curl_setopt($curl, CURLOPT_URL, "http://ws.audioscrobbler.com/2.0/" . "?" . http_build_query($query)
                            );

                            //store $result of curl execution as decoded json object
                            $result = json_decode(curl_exec($curl));

                            //create array $artists to store similarartists array from json $result
                            //this line may create error if $result is empty
                            $count = 0;
                            if (isset($result->similarartists)) {
                                $artists = $result->similarartists;

                                //initialize an accumulator variable for artist count array
                                //loop through $artists array and accumulate count
                                if (count($artists->artist) != 0) {
                                    foreach ($artists->artist as $artist) {
                                        ++$count;
                                    }
                                }
                            }

                            //if $artists array is not empty, store search parameters to database (if user is logged in)
                            //and output html formatted response

                            echo "<table class='special' style='margin-left:auto; margin-right:auto; margin-bottom:15px'>";
                            echo "<tr class='special'>";
                            $newCounter = 0;
                            foreach ($artists->artist as $artist) {
                                if ($newCounter <= 3) {
                                    foreach ($artist->image as $image) {
                                        if ($image->{'size'} == "large") {
                                            echo "<td class='special' style='text-align:center'><img src='" . $image->{'#text'} . "'></br>";
                                        }
                                    }
                                    echo "<button type='button' class='btn btn-default btn-lg' style='text-align:center' onclick='window.open(\"" . $artist->url . "\");' >" . $artist->name . "</button>";
                                    echo "</td>";
                                    $newCounter ++;
                                }
                            }
                            echo "</table>";
                        }
                    } else {
                        echo "<h2 class='w3-red shadowedtext' style='margin-left:15px'>Your search returned no results.</h2>";
                    }

                    echo "<div id='search' style='height:75px'></div>";
                }
            }

            ?>
        </div>
