<!DOCTYPE html>
<!--
    John Galletta
    Abeer 
    Mona 
    Mario Saint-Fleur
    INFO600-001
    February 24, 2018
    Dr. Yuan An
    final Project
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // Include DBconnection file
        require_once 'config.php';

        // API method is hardcoded for now, but can use a $_GET from HTML page depending on requested functionality.
        $method = "artist.getsimilar";

        // TODO Change parameters and get methods to match last.fm parameters.
        $artist = $_GET['artist'];
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
        //if $artists array is not empty, store search parameters to database (if user is logged in)
        //and output html formatted response
        if ($count > 0) {
            if ($userName != null) {
                $sql = "INSERT INTO search (userName, searchParameter) VALUES(?,?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_searchParameter);

                    $param_username = $userName;
                    $param_searchParameter = $query['artist'];
                    $link->set_charset('utf8');
                    if (mysqli_stmt_execute($stmt)) {
                        //echo "Success";
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
            }

            echo "<h2 class='w3-red shadowedtext' style='margin-left:15px'>Search Result: " . $count;
            echo " artist";

            if ($count != 1) {
                echo "s";
            }

            echo " similar to " . $query['artist'] . ".";
            echo "<table class='special' style='margin-left:auto; margin-right:auto; margin-bottom:15px'>";
            echo "<tr class='special' bottom-><th></th><th>Artist</th><th>Bio</tr>";

            foreach ($artists->artist as $artist) {
                echo "<tr class='special'>";

                foreach ($artist->image as $image) {
                    if ($image->{'size'} == "large") {
                        echo "<td class='special'><img src='" . $image->{'#text'} . "'></td>";
                    }
                }

                echo "<td class='special'>" . $artist->name . "</td>";
                echo "<td class='special'><button type='button' class='btn btn-default btn-lg' onclick='window.open(\"" . $artist->url . "\");' >Link to bio</button></td>";
            }
            echo "</table>";
        } else {
            echo "<h2 class='w3-red shadowedtext' style='margin-left:15px'>Your search returned no results.</h2>";
        }
        echo "<div id='search' style='height:75px'></div>";
        //echo json_encode($result);
        ?>
    </body>
</html>
