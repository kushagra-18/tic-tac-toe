
<?php

session_start();

$result = "";

//check if get method returns win

if (isset($_GET['result'])) {
    $result = $_GET['result'];

    if ($result == "win") {
        $arthOperator = '+ 10';
        updateMatchScore($arthOperator);
    } else if ($result == "loose") {
        $arthOperator = '- 10';
        updateMatchScore($arthOperator);
    } else if ($result == "draw") {
        $arthOperator = '+ 5';
        updateMatchScore($arthOperator);
    }
}


function updateMatchScore($arthOperator)
{
    include 'dbconnect.php';

    $sql = "UPDATE leaderboard SET score = score" . $arthOperator . " WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($conn, $sql);
    //update match count in database
    $sql = "UPDATE leaderboard SET matches = matches + 1 WHERE  username = '" . $_SESSION['username'] . "'";
    $resultSql = mysqli_query($conn, $sql);
    if (!$resultSql) {
        echo "<script>alert('Error updating score');</script>";
    }

    //update win count in database
    if ($result == "win") {
        $sqlWin = "UPDATE leaderboard SET wins = wins + 1 WHERE  username = '" . $_SESSION['username'] . "'";
        $resultSql = mysqli_query($conn, $sqlWin);
    }
}
?>