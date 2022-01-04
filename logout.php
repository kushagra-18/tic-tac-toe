<?php
include 'backend/dbconnect.php';

session_start();
session_unset();
session_destroy();

header("location: /PHP/tic-tac-toe/Views/loginView.php");
exit;
?>