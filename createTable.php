<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create Tables</title>
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
        $link = mysqli_connect("localhost", "root", "", "ProjectDB");

// Check connection
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

// Attempt create table query execution
        $sql1 = "CREATE TABLE IF NOT EXISTS users(
                firstName VARCHAR(30) NOT NULL,
                lastName VARCHAR(30) NOT NULL,
                email VARCHAR(70) NOT NULL UNIQUE,
                userName VARCHAR(50) NOT NULL PRIMARY key UNIQUE,
                language VARCHAR(30) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
        $sql2 = "CREATE TABLE IF NOT EXISTS search(
                userName VARCHAR(50) NOT NULL,
                searchParameter NVARCHAR(1000) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT FK_Users_Search FOREIGN KEY (userName) REFERENCES users(userName)
            )";
        if (mysqli_query($link, $sql1)) {
            echo "<h4 align=center>Users table created successfully." . "<br>" . "<a align=center href=index.html>Go to WebSite</a>";
            echo "<hr>";
        } else {
            echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
        }
        if (mysqli_query($link, $sql2)) {
            echo "<h4 align=center>Search history table created successfully." . "<br>" . "<a align=center href=index.html>Go to WebSite</a>";
            echo "<hr>";
        } else {
            echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
        }

// Close connection
        mysqli_close($link);
        