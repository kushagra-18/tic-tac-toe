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
    
   
    <link rel="stylesheet" href="css/style.css">
</head>

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


        <?php $visitedArr = array(); ?>
        <form method="post" action="welcome.php">

            <table class="tic-tac-toe" cellpadding="0" cellspacing="0">
                <tbody>
                    <?php

                    $lastRow = 0;
                    for ($i = 1; $i <= 9; $i++) {
                        $row = ceil($i /3);

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
                                <?php array_push($visitedArr, $i);?>
                                <?php $randVal = playRandom(); ?>
                                <center>
                                    <h2>X</h2>
                                </center> 
                            <?php elseif ($i == $randVal) : ?>                    
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
            <button class = "reset-btn" type="submit" onclick="resetPopup()">Reset</button>

        </form>
        <!-- Tic Tac Toe main game layout ends -->

        <?php print_r($visitedArr); ?>

        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">
                <span class="text-muted">By Kushagra Sharma</span>
            </div>
        </footer>

</body>

<script type="text/javascript">


    function resetPopup() {
        
        confirm("This will reset the game and you will loose points. Are you sure?");

    }

    </script>
    
<script type="text/javascript">
    function enableButton() {
        document.getElementById('play-btn').disabled = false;
    }
</script>




</html>