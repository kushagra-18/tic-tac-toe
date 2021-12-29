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

        //update match count in database
        $sql = "UPDATE leaderboard SET matches = matches + 1,wins = wins + 1 WHERE  username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            echo "<script>alert('Error updating score');</script>";
        }
    }
}

if ($turns >= 5) {

    $sql = "UPDATE leaderboard SET matches = matches + 1 WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($conn, $sql);

    echo "<script>alert('Draw!');</script>";
    //header("location: leaderboard.php");
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
    

    <link rel="stylesheet" href="css/style.css">
</head>

<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reset Game!!!</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This will reset the game and you will loose points. Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"><a href="backend/functions.php?reset=true">Reset</a></button>
            </div>
        </div>
    </div>
</div>

<body>

    <center>
        <font color="white">
            <h2>

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

        <?php $visitedArrUser = array();
        $visitedArrComp = array();
    
        ?>
        <form method="post" action="welcome.php">

            <table class="tic-tac-toe" cellpadding="0" cellspacing="0">
                <tbody>
                    <?php
                    // print value of each cell in session
                    for ($i = 1; $i <= 9; $i++) {
                        if (isset($_SESSION['CELL_' . $i])) {
                            echo $i." ".$_SESSION['CELL_' . $i];
                            echo " - ";
                        }
                    }

                    $lastRow = 0;
                    $turns = 0;
                    for ($i = 1; $i <= 9; $i++) {
                        $row = ceil($i / 3);

                        if ($row !== $lastRow) {
                            $lastRow = $row;

                            if ($i > 1) {
                                echo "</tr>";
                            }
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
                                
                                
                                <?php
                                turnCount();
                                array_push($visitedArrUser, $i);
                                $randVal = playRandom($visitedArrUser, $visitedArrComp);
                                array_push($visitedArrComp, $randVal); 
                                $_SESSION['CELL_' . $randVal] = 'o';

                                ?>
                               
                                <center>
                                    <h2>X</h2>
                                </center>
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
            <button type="button" class="reset-btn" data-toggle="modal" data-target="#resetModal">Reset</button>

        </form>
        <!-- Tic Tac Toe main game layout ends -->

        <?php echo "USER ";
        print_r($visitedArrUser);
        echo "   COMP ";
        print_r($visitedArrComp); ?>

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