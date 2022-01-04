<?php

session_start();

require_once '../backend/dbconnect.php';


/**
 * @Description This is the the Class for the User.
 */


class User{


    /**
     *@description The function is used to login the user
    *@param $username
    *@param $password
    *@return $login {Boolean}
     */
    public function loginUser($username,$password){

        $sql = "Select * from sign_up where username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        
        if ($num || $num == 1) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
    
            header("location: ../welcome.php");
        } else {
            $showAlert = true;
            $showError = "Invalid Credentials";
        }
    }



    }



}
