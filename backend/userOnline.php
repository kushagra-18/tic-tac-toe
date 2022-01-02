<?php

include 'dbconnect.php';
session_start();
$sql = "UPDATE leaderboard SET usertime = NOW() WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "error updating time";
}


?>