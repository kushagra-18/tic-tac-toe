<?php
$login = false;
$showError = false;
session_start();
include 'dbconnect.php';
include 'navBar.php';

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


    <center>
        <h1>
            Tic-Tac-Toe Global Leaderboard
            <br </h1>


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Score</th>
                    </tr>
                </thead>



                <tbody>
                
                <?php
                    
                    $result = mysqli_query($conn, "SELECT * FROM leaderboard INNER JOIN sign_up on leaderboard.username = sign_up.username ORDER BY score DESC");

                   while ($row = mysqli_fetch_array($result)) {

                  //  echo $result;
                   echo '<tr>';
                       echo '<th scope="row">1</th>';
                       echo "<td> ". $row['name'] ."</td>";
                       echo "<td> ". $row['username'] ."</td>";
                       echo "<td> ". $row['score'] ."</td>";
                       echo " </tr>";
                   };

                   mysqli_close($conn);
                    ?>
                </tbody>
            </table>


</body>

</html>