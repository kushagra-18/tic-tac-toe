<?php
$login = false;
$showError = false;
session_start();
include 'backend/dbconnect.php';
include 'backend/navBar.php';
include  'backend/functions.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>

<!-- PHP CODE FOR GAME LOGIC -->

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

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <center>
        <font color="white">
            <h2>
                <br>
                Tic-Tac-Toe
                <?php
                echo "<br>";
                echo "Welcome ";
                echo $_SESSION['username'];

                ?>
        </font>
        </h1>

        <hr>

        <h4><?php echo currentPlayer() ?>'s turn</h4>
        <!-- Tic Tac Toe main game layout starts -->

      

            <!-- <button type="submit" disabled id="play-btn">Play</button>

        </form> -->
        <!-- Tic Tac Toe main game layout ends -->

        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">
                <span class="text-muted">By Kushagra Sharma</span>
            </div>
        </footer>

</body>

<script type="text/javascript">
    function enableButton() {
        document.getElementById('play-btn').disabled = false;
    }
</script>


</html>