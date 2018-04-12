<?php

/* Database credentials. Assuming you are running MySQL
  server with default setting (user 'root' with no password) */


/* define variables */
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ProjectDB";

/* Attempt to connect to MySQL database using object */
$link = new mysqli($servername, $username, $password, $dbName);
$link->set_charset('utf8');
// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>