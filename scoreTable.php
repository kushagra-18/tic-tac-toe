<?php

include 'backend/dbconnect.php';


session_start();

$result = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN sign_up on leaderboard.username = sign_up.username ORDER BY score DESC");

$count = 0;

while ($row = mysqli_fetch_array($result)) {


    //check if user time is more than 1 minute
    $time = $row['usertime'];
    $currentTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
    $currentTime = $currentTime->format('Y-m-d H:i:s');

    //echo $currentTime . " " . $time . "<br>";

    //subtract both times to get the difference
    $diff = strtotime($currentTime) - strtotime($time);
    $userStatus = "Online";
    //echo $diff;
    if ($diff > 1) {
        //set online status to false
        $userStatus = "Offline";
        if (!$result) {
            echo "error updating online status";
        }
    }

    //  echo $result;
    echo '<tr>';
    echo "<td> " . $userStatus. "</td>";
    echo "<td> " . ++$count . "</td>";
    echo "<td> " . $row['name'] . "</td>";
    echo "<td> " . $row['username'] . "</td>";
    echo "<td> " . $row['score'] . "</td>";
    echo " </tr>";
};

mysqli_close($conn);
?>