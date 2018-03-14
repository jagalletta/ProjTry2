<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create DB</title>
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
        <?php
        /* Attempt MySQL server connection. Assuming you are running MySQL
          server with default setting (user 'root' with no password) */
        $link = mysqli_connect("localhost", "root", "");

// Check connection
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

// Attempt create database query execution
        $sql = "CREATE DATABASE ProjectDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
        if (mysqli_query($link, $sql)) {
            echo "<h4 align=center>Database created successfully" . "<br>";
            echo "<a  align=center href=createTable.php>Click here to Create DB Tables.</a>";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

// Close connection
        mysqli_close($link);
        ?>

