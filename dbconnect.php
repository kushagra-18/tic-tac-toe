<?php

// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "tictactoe";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if($conn){
    //echo "Connection Successful";
} else {
    die("Connection Failed because ".mysqli_connect_error());

}
?>