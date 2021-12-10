<?php
        $login = false;
        $showError = false;
        session_start();
        include 'dbconnect.php';
        include 'navBar.php';
        
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
            header("location: login.php");
            exit;
        }
        
        ?> 


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tic Tac Toe |
        <?php
        echo $_SESSION['username'];

        ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>

<body>

    <center>
        <h1>
            <font color="white">Tic-Tac-Toe</font>

            <?php

            echo "<br>";
            echo "Welcome ";
            echo $_SESSION['username'];

            ?>
        </h1>


</body>

</html>