<?php
$login = false;
$showError = false;
$showAlert = false;
session_start();
include 'dbconnect.php';
include 'navBar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $oldpass = $_POST['oldpass'];
    $pass = $_POST['password'];

    $username = $_SESSION['username'];

    $sql = "SELECT password from sign_up where username = '$username'";
    $result = mysqli_query($conn, $sql);

    $dataOldPass = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dataOldPass = $row['password'];
        }
    }

    if ($oldpass == $dataOldPass) {
        $sql = "UPDATE Sign_up SET password = '$pass' WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = true;
        } 
        $conn->close();
    }else{
        $showError = true;
        $conn->close();
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tic Tac Toe | Change password </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>

    <h1>
        <font color="white">Tic-Tac-Toe</font>
    </h1>

    <?php
    if($showAlert){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your password has been changed.
    </div> ';
    }
    if($showError){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Old password does not match.
    </div> ';
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form action="change.php" method="post">

                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input id="oldpass" type="password" class="form-control" name="oldpass" placeholder="Old Password" required>
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" required placeholder="New Password">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>