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
    public function __construct($username, $password, $confirmPassword, $email, $fullname)
    {

        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullname = $fullname;
        $this->confirmPassword = $confirmPassword;
    }

    public function signupController()
    {


        if(!$this->validateUser())
        {
            return;
        }

        try {
            $this->signupUser($this->username, $this->password, $this->confirmPassword, $this->email, $this->fullname);
        } catch (Exception $e) {
            $this->showError = $e->getMessage();
        }
    }

    /**
     * @description The function is used to validate the user input for signup
     * using regex
     * @param $username - username
     * @param $password - password
     * @param $confirmPassword - confirm password
     * @param $email - email
     * return  {Boolean} - true if valid else false
     * @author  Kushagra Sharma 
     */

    private function validateUser()
    {

        if (strlen($this->password) < 8) {
            $showError = "Password must be at least 8 characters long";
            return false;
        } else if (!preg_match("#[0-9]+#", $this->password)) {
            $showError = "Password must include at least one number";
            return false;
        } else if (!preg_match("#[A-Z]+#", $this->password)) {
            $showError = "Password must include at least one uppercase letter";
            return false;
        } else if (!preg_match("#[a-z]+#", $this->password)) {
            $showError = "Password must include at least one lowercase letter";
            return false;
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $showError = "Invalid email format";
            return false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $showError = "Username must contain only letters and numbers";
            return false;
        } else if ($this->exists == true) {
            $showError = "Username or email already exists";
            return false;
        } else {
            return true;
        }
    }


    /**
     * @description The function is used as a login controller 
     * @param $username
     * @param $password
     */

    public function loginController()
    {

        try {
            if ($this->loginUser($this->username, $this->password)) {
                session_start();
                echo "Login Successful";
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $this->username;

                header("location: ../welcome.php");
            } else {
                $this->showAlert = true;
                $this->showError = "Invalid Credentials";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
