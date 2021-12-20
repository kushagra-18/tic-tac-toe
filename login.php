<?php
$login = false;
$showError = false;
session_start();

if (isset($_SESSION['loggedin'])) {
    header("location: welcome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'backend/dbconnect.php';
    
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

        $sql = "UPDATE leaderboard SET status = 'Online' WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        header("location: welcome.php");
    } else {
        $showError = "Invalid Credentials";
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
            -ms-transform: translate(-20%, -10%);
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
                            <h3 class="panel-title">Please log in</h3>
                        </div>
                        <div class="panel-body">
                            <form action="login.php" method="post">

                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="username" type="text" class="form-control" name="username" placeholder="User Name" required>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                                </div>
                                <br>
                                <a href=sign_up.php>New user?</a>
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>