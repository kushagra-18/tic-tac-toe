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

<?php

if ($_POST['cell']) {
    $win = play($_POST['cell']);

    if ($win) {
        echo "<script>alert('You win!');</script>";
        //update leaderboard score in database
        $sql = "UPDATE leaderboard SET score = score + 10 WHERE username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<script>alert('Error updating score');</script>";
        }
    }
}

if (playsCount() >= 9) {
    echo "<script>alert('Draw!');</script>";
    //header("location: leaderboard.php");
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

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

        <h4><?php echo currentPlayer() ?></h4>
        <!-- Tic Tac Toe main game layout starts -->

        <form method="post" action="welcome.php">

            <table class="tic-tac-toe" cellpadding="0" cellspacing="0">
                <tbody>

                    <?php

    


                    $lastRow = 0;
                    for ($i = 1; $i <= 9; $i++) {
                        $row = ceil($i / 3);

                        if ($row !== $lastRow) {
                            $lastRow = $row;

                            if ($i > 1) {
                                echo "</tr>";
                            }

                            echo "<tr class='row-{$row}'>";
                        }

                        $additionalClass = '';

                        if ($i == 2 || $i == 8) {
                            $additionalClass = 'vertical-border';
                        } else if ($i == 4 || $i == 6) {
                            $additionalClass = 'horizontal-border';
                        } else if ($i == 5) {
                            $additionalClass = 'center-border';
                        }
                    ?>

                        <td class="cell-<?= $i ?> <?= $additionalClass ?>">
                            <?php if (getCell($i) === 'x') : ?>
                                <center>
                                    <h2>X</h2>
                                </center> <?php playRandom($i) ?>
                            <?php elseif (getCell($i) === 'o') : ?>                    
                                <center>
                                    <h2>O</h2>
                                </center>
                            <?php else : ?>
                                <center>
                                    <input type="radio" name="cell" value="<?= $i ?>" onclick="enableButton()" />
                                </center>
                            <?php endif; ?>
                        </td>

                    <?php } ?>

                    </tr>
                </tbody>
            </table>

            <button type="submit" disabled id="play-btn">Play</button>

        </form>
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