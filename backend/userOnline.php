<?php

include 'dbconnect.php';

session_start();

//update current timestamp in database
$sql = "UPDATE leaderboard SET usertime = NOW() WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "error updating time";
}


//check the time in database
$sql = "SELECT usertime FROM leaderboard WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "error getting time";
}

$result = mysqli_fetch_assoc($result);
$time = $result['usertime'];

//get currentTime in IST
$currentTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
$currentTime = $currentTime->format('Y-m-d H:i:s');



if (strtotime($currentTime) > strtotime($time) + 1000)
{
//set online status to false
$sql = "UPDATE leaderboard SET status = 'Offline' WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "error updating online status";
    }
}
?>