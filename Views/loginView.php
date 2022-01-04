<!DOCTYPE html>
<html lang="en">

<?php
include '../Controllers/login.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $login = new Controller($username, $password);
        $login->loginController();

        $showError = $login->showError;
        $showAlert = $login->showAlert;

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}


?>

<head>
    <title>Tic Tac Toe | Sign in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url("../images/background.jpg");
            background-repeat: repeat;
            background-size: cover;

        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-20%, -10%);
            transform: translate(-50%, -50%);
            -webkit-animation: fadein 1s, expand 0.5s;
            /* -webkit-animation: expand 0.5s; */
        }

        @-webkit-keyframes fadein {

            /* Safari and Chrome */
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes identifier {

            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }

        }

        @-webkit-keyframes expand {
            0% {
                height: 0px
            }

            100% {
                height: 290px
            }
        }

        .jumbotron {
            background: no-repeat center center;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <center>
        <div class="jumbotron">

            <h1>
                <font color="white">Tic-Tac-Toe</font>
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please log in</h3>
                        </div>
                        <div class="panel-body">
                            <form action="../Views/loginView.php" method="post">

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
                                <a href=../sign_up.php>New user?</a>
                                <br>
                                <br>
                                <?php
                                if ($showError) {
                                    echo "<div class='alert alert-danger'>
                                    <strong>Error!</strong> $showError
                                </div>";
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>