<?php

// Connecting to the Database
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "tictactoe";


$servername = "l6glqt8gsx37y4hs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "zdufljbxx02ayg0j";
$password = "xx70c4amyg6ipj30";
$database = "zll74kkke20ditz2";


// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if($conn){
    //echo "Connection Successful";
} else {
    die("Connection Failed because ".mysqli_connect_error());

}
?>