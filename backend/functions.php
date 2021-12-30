<?php
include 'dbconnect.php';

if (isset($_GET['reset'])){
     $resetBool = $_GET['reset'];
    if($resetBool == 'true'){
        resetBoard();
        echo "<script>alert('Rddddddddddddeset');</script>";
        header("location: /PHP/tic-tac-toe/logout.php");
    }
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$name = "'s [X]";

$_SESSION['PLAYER_X_NAME'] = $_SESSION['username'] . " turns " . $name;
$_SESSION['PLAYER_O_NAME'] = "CPU's turn [O]";

function resetBoard()
{
    resetPlaysCount();

    for ($i = 1; $i <= 9; $i++) {
        unset($_SESSION['CELL_' . $i]);
    }
}

function playsCount()
{
    return $_SESSION['PLAYS'] ? $_SESSION['PLAYS'] : 0;
}


function addPlaysCount()
{
    if (!$_SESSION['PLAYS']) {
        $_SESSION['PLAYS'] = 0;
    }

    $_SESSION['PLAYS']++;

    //echo $_SESSION['PLAYS'];
}

$turns = 0;

function turnCount(){

//check if cell session is filled till 5
    if(playsCount() >= 5){

        echo "<script>alert('Draw!')</script>";
        resetBoard();

    }
}

function resetPlaysCount()
{
    $_SESSION['PLAYS'] = 0;
}

function playerName($player = 'x')
{
    return $_SESSION['PLAYER_' . strtoupper($player) . '_NAME'];
}

function getTurn()
{
    return $_SESSION['TURN'] ? $_SESSION['TURN'] : 'x';
}

function currentPlayer()
{
    return playerName(getTurn());
}

function play($cell = '')
{

    if (getCell($cell)) {
        return false;
    }

    $_SESSION['CELL_' . $cell] = getTurn();
    addPlaysCount();
    $win = playerPlayWin($cell);

    $winComp = compPlayWin($cell);

    if($winComp){

        $winComp = 'comp';

    }

    if (!$win) {
        // do nothing
    } else {
        resetBoard();
    }


    if (!$winComp) {
        // do nothing
    } else {
        resetBoard();
    }

    return $win ? $win : $winComp;
}


function playRandom()
{

  echo "<script>alert('TESTING FOR TIMES')</script>";

    $random = -1;
    
    $visitedArr = array_merge($_SESSION['visitedArrUser'],$_SESSION['visitedArrComp']);

    //creating random numbers from 0 to 9 excluding the visited cells

    do {   

        $random = rand(1,9);
        
    } while(in_array($random, $visitedArr));
    
    return $random;
}

function getCell($cell = '')
{

    return $_SESSION['CELL_' . $cell];
}



function playerPlayWin($cell = 1)
{
    if (playsCount() < 3) {
        return false;
    }

    $column = $cell % 3;
    if (!$column) {
        $column = 3;
    }

    $row = ceil($cell / 3);

    $player = getTurn();

   // echo $player;

    return isVerticalWin($column, $player) || isHorizontalWin($row, $player) || isDiagonalWin($player);
}


function compPlayWin($cell = 1){


    if(playsCount() < 3){
        return false;
    }

    $column = $cell % 3;
    if(!$column){
        $column = 3;
    }

    $row = ceil($cell / 3);

    //echo "<script>alert('TESTING FOR COMP')</script>";

    return isVerticalWinComp($column,$turn = 'o') || isHorizontalWinComp($row, $turn = 'o') || isDiagonalWinComp($turn = 'o');

}

function isVerticalWin($column = 1, $turn = 'x')
{
    return getCell($column) == $turn &&
        getCell($column + 3) == $turn &&
        getCell($column + 6) == $turn;
}

function isHorizontalWin($row = 1, $turn = 'x')
{
    return getCell($row) == $turn &&
        getCell($row + 1) == $turn &&
        getCell($row + 2) == $turn;
}

function isDiagonalWin($turn = 'x')
{
    $win = getCell(1) == $turn &&
        getCell(9) == $turn;

    if (!$win) {
        $win = getCell(3) == $turn &&
            getCell(7) == $turn;
    }

    return $win && getCell(5) == $turn;
}

function isVerticalWinComp($column = 1, $turn = 'o')
{
    return getCell($column) == $turn &&
        getCell($column + 3) == $turn &&
        getCell($column + 6) == $turn;
}

function isHorizontalWinComp($row = 1, $turn = 'o')
{
    return getCell($row) == $turn &&
        getCell($row + 1) == $turn &&
        getCell($row + 2) == $turn;
}

function isDiagonalWinComp($turn = 'o')
{
    $win = getCell(1) == $turn &&
        getCell(9) == $turn;

    if (!$win) {
        $win = getCell(3) == $turn &&
            getCell(7) == $turn;
    }

    return $win && getCell(5) == $turn;
}