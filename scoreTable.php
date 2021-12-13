<?php

include 'dbconnect.php';

session_start();

$result = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN sign_up on leaderboard.username = sign_up.username ORDER BY score DESC");

$count = 0;

while ($row = mysqli_fetch_array($result)) {

    //  echo $result;
    echo '<tr>';
    echo "<td> " . $row['status'] . "</td>";
    echo "<td> " . ++$count . "</td>";
    echo "<td> " . $row['name'] . "</td>";
    echo "<td> " . $row['username'] . "</td>";
    echo "<td> " . $row['score'] . "</td>";
    echo " </tr>";
};

mysqli_close($conn);
?>