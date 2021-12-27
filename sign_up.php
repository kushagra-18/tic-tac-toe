<?php
include 'backend/dbconnect.php';

session_start();

if (isset($_SESSION['loggedin'])) {
    header("location: welcome.php");
    exit;
}

$exists = false;
$showAlert = false;
$showError = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passCheck = $_POST['passwordCheck'];
    $username = $_POST['username'];

    //check if user exists in database already
    $sql = "SELECT * FROM sign_up WHERE username = '$username' or email = '$email'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $exists = true;
    }

    echo $exists;

    //validate passwords length and special characters
    if (strlen($pass) < 8) {
        $showError = "Password must be at least 8 characters long";
    } else if (!preg_match("#[0-9]+#", $pass)) {
        $showError = "Password must include at least one number";
    } else if (!preg_match("#[A-Z]+#", $pass)) {
        $showError = "Password must include at least one uppercase letter";
    } else if (!preg_match("#[a-z]+#", $pass)) {
        $showError = "Password must include at least one lowercase letter";
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $showError = "Invalid email format";
    }else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $showError = "Username must contain only letters and numbers";
    } else if ($exists == true) {
        // $showAlert = true;
        $showError = "Username or email already exists";
    } else {

        if ($pass == $passCheck && $exists == false) {
            $sql = "INSERT INTO sign_up (name, email, password,username) VALUES ('$name', '$email', '$pass','$username')";
            $result = mysqli_query($conn, $sql);

            $sqlLeaderboard = "INSERT INTO leaderboard (username,score,status) VALUES ('$username',0,'Online')";
            $resultLeaderboard = mysqli_query($conn, $sqlLeaderboard);

            if ($result) {
                $showAlert = true;
            } else {
                $showError = "Passwords do not match";
            }
            $conn->close();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tic Tac Toe | Sign in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url("images/background.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>

    <center>
        <h1>
            <font color="white">Tic-Tac-Toe</font>
        </h1>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please sign in</h3>
                        </div>
                        <div class="panel-body">
                            <form action="sign_up.php" method="post">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="username" type="text" class="form-control" name="username" placeholder="User Name" required>

                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Full Name" required>

                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="email" type="text" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                                    
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="passwordCheck" type="password" class="form-control" name="passwordCheck" required placeholder="Confirm Password">
                                </div>
                                <br>
                                <a href=login.php>Already a user?</a>
                                <br>
                                <?php

                                if ($showAlert) {
                                    echo "<div class='alert alert-success'>
                                    <strong>Success!</strong> You have been registered. Please <a href = login.php>login again</a>
                                    </div>";
                                } else if ($showError) {
                                    echo "<div class='alert alert-danger'>
                                    <strong>Error!</strong> $showError
                                    </div>";
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>