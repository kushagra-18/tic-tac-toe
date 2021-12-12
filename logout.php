<?php
include 'dbconnect.php';
session_start();

$username = $_SESSION['username'];

$sql = "UPDATE leaderboard SET status = 'Offline' WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if(!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


session_unset();
session_destroy();

header("location: login.php");
exit;
?>