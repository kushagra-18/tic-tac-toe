<?php

include_once("../Models/User.php");
require_once '../backend/dbconnect.php';

$login = false;
$showError = false;
session_start();


if (isset($_SESSION['loggedin'])) {
    header("location: ../welcome.php");
    exit;
}

/**
 * @Description This is the the Class for the controller. inherit from User
 * used for login and signup
 */


class Controller extends User
{
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

    }

    public function loginController()
    {
        
        try
        {
            $this->loginUser($this->username, $this->password);
        }
        catch (Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}

