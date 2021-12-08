<?php

// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "tictactoe";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passCheck = $_POST['passwordCheck'];
}

if($pass != $passCheck){
    echo "Passwords do not match";
}else{

// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
else{
    echo "Connection was successful";

    $sql = "INSERT INTO sign_up (name, email, password) VALUES ('$name', '$email', '$pass')";
    $result = mysqli_query($conn, $sql);

    if($result){
        echo "New record created successfully";
      }
      else{
        echo "Error: ". $sql ."<br>". mysqli_error($conn);
      }
       $conn->close();

    }
}


?>