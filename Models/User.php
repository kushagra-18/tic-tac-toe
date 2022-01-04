<?php

include_once("../includes/dbconnect.php");

/**
 * @Description This is the the Class for the User.
 */

class User extends dbConnect
{

    public $showError,$showAlert;
    /**
     *@description The function is used to login the user
     *using the username and password, if the user is found
     *@param $username
     *@param $password
     *@return $login {Boolean}
     */
    public function loginUser($username, $password)
    {

        $sql = "Select * from sign_up where username='$username' AND password='$password'";
        
        $result = mysqli_query($this->dbconnect(), $sql);

        $num = mysqli_num_rows($result);

        echo $num;

        if ($num || $num == 1) {
            $login = true;
            session_start();
            echo "Login Successful";
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("location: ../welcome.php");
        } else {
            $showAlert = true;
            $showError = "Invalid Credentials";
        }
    }
}
