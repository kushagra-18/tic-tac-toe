<?php

$login = false;
$showError = false;
session_start();


if (isset($_SESSION['loggedin'])) {
    header("location: ../welcome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../backend/dbconnect.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "Select * from sign_up where username='$username' AND password='$password'";
    // $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    // echo $result;
    $num = mysqli_num_rows($result);
    
    if ($num || $num == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        header("location: ../welcome.php");
    } else {
        $showAlert = true;
        $showError = "Invalid Credentials";
    }
}

?>

