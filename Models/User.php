<?php

include_once("../includes/dbconnect.php");

/**
 * @Description This is the the Class for the User.
 */

class User extends dbConnect
{

    public $showError, $showAlert;

    /**
     *@description The function is used to login the user
     *using the username and password, if the user is found
     *then the user is logged in and redirected to the home page.
     *else error message is displayed.
     *@param $username
     *@param $password
     *@return  {Boolean}
     *@author  Kushagra Sharma
     */

    public function loginUser($username, $password)
    {

        $sql = "Select * from sign_up where username='$username' AND password='$password'";

        $result = mysqli_query($this->dbconnect(), $sql);

        $num = mysqli_num_rows($result);

        if ($num || $num == 1) {

            $this->login = true;
            return true;
        }

        return false;
    }

    /**
     *@description The function is used to signup the user
     *using various parameters. if parameters are valid then
     *the user is signed up and redirected to the home page.
     *else error message is displayed.
     *@param $username
     *@param $password
     *@param $confirmPassword
     *@param $email
     *@param $fullname
     *@return  {None}
     *@author  Kushagra Sharma
     */

    public function signupUser($username, $password, $confirmPassword, $email, $fullname)
    {

        //check if user exists in database already
        $sql = "SELECT * FROM sign_up WHERE username = '$username' or email = '$email'";
        $result = mysqli_query($this->dbconnect(), $sql);
        $resultCheck = mysqli_num_rows($result);

        $exists = false;

        if ($resultCheck > 0) {
            $exists = true;
        }

        if ($password == $confirmPassword && $exists == false) {

            //add current date to database

            $date = date("Y-m-d");
            $sql = "INSERT INTO sign_up (name, email, password,username,createdOn) VALUES ('$fullname', '$email', '$password','$username','$date')";
            $result = mysqli_query($this->dbconnect(), $sql);

            return true;
        }

        return false;
    }
}
