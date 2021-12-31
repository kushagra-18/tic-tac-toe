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
                <button type="button" class="btn btn-primary"><a href="welcome.php">Reset</a></button>
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
            </h2>
        </font>
        <hr>
        <h4><?php echo currentPlayer(); ?></h4>

        <!-- Tic Tac Toe main game layout starts -->

        <center>
            <form method="post" id="gameForm" action="welcome.php" style="display: inline-block;">
                <table class="tic-tac-toe" style="text-align: center">
                    <tbody>
                        <tr>
                            <td id="cell_1" data-id="1" onclick="cellTapped(this)"></td>
                            <td id="cell_2" data-id="2" onclick="cellTapped(this)"></td>
                            <td id="cell_3" data-id="3" onclick="cellTapped(this)"></td>
                        </tr>
                        <tr>
                            <td id="cell_4" data-id="4" onclick="cellTapped(this)"></td>
                            <td id="cell_5" data-id="5" onclick="cellTapped(this)"></td>
                            <td id="cell_6" data-id="6" onclick="cellTapped(this)"></td>
                        </tr>
                        <tr>
                            <td id="cell_7" data-id="7" onclick="cellTapped(this)"></td>
                            <td id="cell_8" data-id="8" onclick="cellTapped(this)"></td>
                            <td id="cell_9" data-id="9" onclick="cellTapped(this)"></td>
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

        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container">
                <span class="text-muted">By Kushagra Sharma</span>
            </div>
        </footer>
</body>


<!-- import jquery from cdn -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    let turn = "player";

    let selectedCells = new Map();
    let computerSelectedCells = new Map();
    let userSelectedCells = new Map();

    /**@abstract
     * @param {result} result - result of the game
     * AJAX call to update the leaderboard 
     */


    function pointsUpdate(result) {
        $.ajax({
            url: 'backend/updateMatchScore.php?result=' + result,'type': 'GET',
            complete: function(response) {
                console.log(response.responseText);
            },
            error: function() {
                console.log(response.responseText);
            }
        });
        return false;
    }

    /**@abstract
     * @param {Maps} selectedCells
     * check if the match is drawn
     * checking if the size of the selected cells is equal to 9
     * @returns {boolean}
     */

    function isDraw(selectedCells) {
        if (selectedCells.size == 9) {
            return true;
        }
        return false;
    }


    /**
     * function to check if the player (user or cpu) has won the game
     * checking if the win cells are filled or not;
     * @return {boolean}
     * @param {Map} selectedCells
     */

    function WinPos(selectedCells) {

        if (selectedCells.has(1) && selectedCells.has(5) && selectedCells.has(9)) {
            return true;
        } else if (selectedCells.has(3) && selectedCells.has(4) && selectedCells.has(7)) {
            return true;
        } else if (selectedCells.has(3) && selectedCells.has(6) && selectedCells.has(9)) {
            return true;
        } else if (selectedCells.has(1) && selectedCells.has(2) && selectedCells.has(3)) {
            return true;
        } else if (selectedCells.has(4) && selectedCells.has(5) && selectedCells.has(6)) {
            return true;
        } else if (selectedCells.has(7) && selectedCells.has(8) && selectedCells.has(9)) {
            return true;
        } else if (selectedCells.has(1) && selectedCells.has(4) && selectedCells.has(7)) {
            return true;
        } else if (selectedCells.has(2) && selectedCells.has(5) && selectedCells.has(8)) {
            return true;
        } else if (selectedCells.has(3) && selectedCells.has(5) && selectedCells.has(7)) {
            return true;
        }

        return false;
    }

    /**@abstract
     * function to merge two hashmaps ignoring the duplicates
     * will be used to check all the visited and empty cells
     * @param map1
     * @param map2
     * @returns {None}
     */

    function mergeMaps(map1, map2) {
        for (let [key, value] of map1) {
            selectedCells.set(key, value);
        }
        for (let [key, value] of map2) {
            selectedCells.set(key, value);
        }

    }

    /**
     * function to make Poor player's choice visible.
     * computer is not suppose to allow him to win :P
     *
     * @param obj
     */


    function cellTapped(obj) {
        const cellTapped = $(obj).data("id");
        if (selectedCells.has(cellTapped)) {
            alert('Oops!, cannot select this cell. Try another one.');
            return;
        }

        const cell = document.getElementById('cell_' + cellTapped);

        cell.innerHTML = '<img src="images/cross.png" alt="cross" width="75" height="75">';
        userSelectedCells.set(cellTapped, 'x');

        mergeMaps(computerSelectedCells, userSelectedCells);

        let did_player_win = WinPos(userSelectedCells);
        if (did_player_win) {
            pointsUpdate('win');
            alert('Yay! Congratulations You Won!!!!');
        } else if (isDraw(selectedCells)) {
            alert('Match Drawn');
        } else {
            chooseOpponentCell(cellTapped);
        }
    }


    /**
     * function to determine computer choice.
     * Aim of this function is to make player's life miserable :P
     * @param cellTapped
     */

    function chooseOpponentCell(cellTapped) {
        // TODO: set computer game logic.
        // - Try to make it hard for the user to win.


        const toBeSelectedCell = Math.floor(Math.random() * 9) + 1
        if (!selectedCells.has(toBeSelectedCell)) {
            const cell = document.getElementById('cell_' + toBeSelectedCell);
            computerSelectedCells.set(toBeSelectedCell, 'o');
            mergeMaps(computerSelectedCells, userSelectedCells);
            //console.log(computerSelectedCells);
            cell.innerHTML = '<img src="images/zero.png" alt="zero" width="75" height="75">';
        } else {
            chooseOpponentCell();
        }

        if (WinPos(computerSelectedCells)) {
            pointsUpdate('loose');
            alert('Sorry! You lost. Better luck next time.');
        } else if (isDraw(selectedCells)) {
            alert('Match Drawn');
        }

    }
</script>

</html>