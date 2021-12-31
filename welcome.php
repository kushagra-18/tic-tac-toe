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
    else if ($win === 'comp') {
        echo "<script>alert('You lose!');</script>";
        //update leaderboard score in database
        $sql = "UPDATE leaderboard SET score = score - 10 WHERE username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        //update match count in database
        $sql = "UPDATE leaderboard SET matches = matches + 1 WHERE  username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<script>alert('Error updating score');</script>";
        }
    }
}
if ($turns >= 5000) {
    //update leaderboard score in database
    $sql = "UPDATE leaderboard SET score = score - 5 WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($conn, $sql);
    $sql = "UPDATE leaderboard SET matches = matches + 1 WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($conn, $sql);
    resetBoard();
    echo "<script>alert('Draw!');</script>";
    //header("location: leaderboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Tic Tac Toe |
        <?php
            echo $_SESSION['username'];
        ?>
    </title>
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
<!--    <center>-->
        <font color="white">
            <h2>
                Tic-Tac-Toe
                <?php
                    echo "<br>";
                    echo "Welcome ";
                    echo $_SESSION['username'];
                ?>
            </h2>
        </font>
        <hr>
        <h4><?php echo currentPlayer(); ?></h4>
        <!-- Tic Tac Toe main game layout starts -->
        <?php
            $_SESSION['visitedArrUser'] = [];
            $_SESSION['visitedArrComp'] = [];
            $_SESSION['visited']        = [];
        ?>
        <center>
            <form method="post" id="gameForm" action="welcome.php" style="display: inline-block;">
                <table class="tic-tac-toe" style="text-align: center">
                    <tbody>
                        <tr>
                            <td id="cell_1" data-id="1" onclick="cell_tapped(this)"></td>
                            <td id="cell_2" data-id="2" onclick="cell_tapped(this)"></td>
                            <td id="cell_3" data-id="3" onclick="cell_tapped(this)"></td>
                        </tr>
                        <tr>
                            <td id="cell_4" data-id="4" onclick="cell_tapped(this)"></td>
                            <td id="cell_5" data-id="5" onclick="cell_tapped(this)"></td>
                            <td id="cell_6" data-id="6" onclick="cell_tapped(this)"></td>
                        </tr>
                        <tr>
                            <td id="cell_7" data-id="7" onclick="cell_tapped(this)"></td>
                            <td id="cell_8" data-id="8" onclick="cell_tapped(this)"></td>
                            <td id="cell_9" data-id="9" onclick="cell_tapped(this)"></td>
                        </tr>
                    </tbody>
                </table>
                <!-- <button type="submit" disabled id="play-btn">Play</button> -->
                <button type="button" class="reset-btn" data-toggle="modal" data-target="#resetModal">Reset</button>
            </form>
        </center>
        <!-- Tic Tac Toe main game layout ends -->
        <script>
            function formSubmit(radioObj) {
                if (radioObj.checked) {
                    document.getElementById("gameForm").submit();
                }
            }
        </script>
        <?php
            echo "USER ";
            print_r($_SESSION['visitedArrUser']);
            echo "   COMP ";
            print_r($_SESSION['visitedArrComp']);
        ?>
        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">
                <span class="text-muted">By Kushagra Sharma</span>
            </div>
        </footer>
</body>
<script type="text/javascript">
    let turn = "player";
    let selected_cells = [];
    let computer_selected_cells = [];
    let user_selected_cells     = [];
    function enableButton() {
        document.getElementById('play-btn').disabled = false;
    }
    /**
     * function to make Poor player's choice visible.
     * computer is not suppose to allow him to win :P
     *
     * @param obj
     */
    function cell_tapped(obj) {
        const cell_tapped = $(obj).data("id");
        if (selected_cells.indexOf(cell_tapped) !== -1) {
            alert('Oops!, cannot select this cell. Try another one.');
            return;
        }
        const cell = document.getElementById('cell_' + cell_tapped);
        cell.innerHTML = '<img src="images/cross.png" alt="cross" width="75" height="75">';
        selected_cells.push(cell_tapped);
        // TODO: need to determine if the selected cell makes the player win
        let did_player_win = false;
        if (did_player_win) {
            alert('Yay! Congratulations You Won!!!!');
        } else {
            choose_opponent_cell(cell_tapped);
        }
    }
    /**
     * function to determine computer choice.
     * Aim of this function is to make player's life miserable :P
     *
     * @param cell_tapped
     */
    function choose_opponent_cell(cell_tapped) {
        // TODO: set computer game logic.
        // - Check which cell user selected
        // - Check all the cells selected by user and find if he is about to win ?
        // - Check all the cells selected by computer and find if computer is about to win ?
        // - Try to make it hard for the user to win.
        const to_be_selected_cell = Math.floor(Math.random() * 9) + 1
        if (selected_cells.indexOf(to_be_selected_cell) === -1) {
            const cell = document.getElementById('cell_' + to_be_selected_cell);
            cell.innerHTML = '<img src="images/zero.png" alt="zero" width="75" height="75">';
        } else {
            choose_opponent_cell();
        }
    }
</script>
</html>