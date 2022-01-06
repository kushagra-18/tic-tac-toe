<?php

include '../Controllers/controlUsers.php';

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


    try {
        $signup = new Controller($username, $password, $confirmPassword, $email, $fullname);
        $signup->signupController();
        $showError = $signup->showError;
        $showAlert = $signup->showAlert;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
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
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
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

        .jumbotron {
            background: no-repeat center center;
            color: #ffffff;
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
                height: 435px;
            }
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
                            <h3 class="panel-title">Please sign in</h3>
                        </div>
                        <div class="panel-body">
                            <form action="../Views/signupView.php" method="post">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input data-toggle="tooltip" data-placement="top" title="Make sure your Username is unique and contains only letters and numbers" id="username" type="text" class="form-control" name="username" required required placeholder="User Name">

                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="name" type="text" class="form-control" name="name" required placeholder="Full Name">

                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input data-toggle="tooltip" data-placement="top" title="Make sure your Email is unique" id="email" type="text" class="form-control" name="email" required placeholder="Email" onchange="validateEmail(this);">
                                    <label id="labelEmailText" style="visibility: hidden; color:red"></label></span></td>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input data-toggle="tooltip" data-placement="top" title="Choose a strong password with minimum length of 8, must have a special (@#$%!&), lowercase (a-b), uppercase (A-B) characters and numbers (0-9)." id="password" type="password" class="form-control" name="password" onchange="validatePassword(this)" required placeholder="Password">

                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="passwordCheck" type="password" class="form-control" name="passwordCheck" required placeholder="Confirm Password">
                                </div>
                                <br>
                                <a href= ../Views/loginView.php>Already a user?</a>
                                <br>
                                <br>

                                <label id="labelText" style="visibility: hidden; color:red"></label></span></td>
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

<script type="text/javascript">
    function validateEmail(inputField) {

        var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,8})?$/.test(inputField.value);
        if (emailRegex) {
            document.getElementById("email").style.border = "2px solid black";
            document.getElementById("labelEmailText").style.display = "none";
        } else {
            document.getElementById("email").style.border = "3px solid red";
            document.getElementById("email").focus();
            $("#labelEmailText").html("Enter a valid email address");
            document.getElementById("labelEmailText").style.visibility = "visible";
        }
    }


    function validatePassword(event) {

        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/
        if (event.value.match(passw)) {
            document.getElementById("password").style.border = "2px solid black";
            document.getElementById("labelText").style.display = "none";
        } else {
            document.getElementById("password").style.border = "3px solid red";
            document.getElementById("password").focus();
            $("#labelText").html("Choose a strong password with minimum length of 8, must have a special (@#$%!&), lowercase (a-b), uppercase (A-B) characters and numbers (0-9).")
            document.getElementById("labelText").style.visibility = "visible";
        }
    }
</script>


</html>