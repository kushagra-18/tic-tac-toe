<?php
$login = false;
$showError = false;
session_start();
include 'backend/dbconnect.php';
include 'backend/navBar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tic Tac Toe | Leaderboard </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</head>

<body>

<?php

?>

    <center>
        <font color="white">

            <h1>
                Tic-Tac-Toe Global Leaderboard
                <br>
            </h1>


            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Ranking</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Matches</th>
                        <th scope="col">Score</th>
                    </tr>
                </thead>
                <tbody id="responds">


                </tbody>
            </table>

            <script>

                setInterval(function firstTime() {

                    $.get('scoreTable.php', function(data) {
                        $('#responds').html(data);
                    });
                }, 100);
            </script>
        </font>
    </center>


</body>

</html>