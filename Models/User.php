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
     *@return  {None}
     *@author  Kushagra Sharma
     */

    public function loginUser($username, $password)
    {

        $sql = "Select * from sign_up where username='$username' AND password='$password'";

        $result = mysqli_query($this->dbconnect(), $sql);

        $num = mysqli_num_rows($result);

        if ($num || $num == 1) {
            $this->login = true;
            session_start();
            echo "Login Successful";
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            header("location: ../welcome.php");
        } else {
            $this->showAlert = true;
            $this->showError = "Invalid Credentials";
        }
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

            if ($password == $confirmPassword && $exists == false && self::validateUser($username, $password, $email, $fullname)) {
               
                //add current date to database

                $date = date("Y-m-d");
                $sql = "INSERT INTO sign_up (name, email, password,username,createdOn) VALUES ('$fullname', '$email', '$password','$username','$date')";
                $result = mysqli_query($this->dbconnect(), $sql);

                $sqlLeaderboard = "INSERT INTO leaderboard (username,score) VALUES ('$username',0)";
                $resultLeaderboard = mysqli_query($this->dbconnect(), $sqlLeaderboard);

                if (!$resultLeaderboard) {
                    //sql error
                    echo "Error: " . $sqlLeaderboard . "<br>" . mysqli_error($this->dbconnect());
                }

                if ($result) {
                    $showAlert = true;
                } else {
                    $showError = "Passwords do not match";
                }
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

    private static function validateUser($password, $username,$exists,$email){

        if (strlen($password) < 8) {
            $showError = "Password must be at least 8 characters long";
            return false;
        } else if (!preg_match("#[0-9]+#", $password)) {
            $showError = "Password must include at least one number";
            return false;
        } else if (!preg_match("#[A-Z]+#", $password)) {
            $showError = "Password must include at least one uppercase letter";
            return false;
        } else if (!preg_match("#[a-z]+#", $password)) {
            $showError = "Password must include at least one lowercase letter";
            return false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $showError = "Invalid email format";
            return false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $showError = "Username must contain only letters and numbers";
            return false;
        } else if ($exists == true) {
            $showError = "Username or email already exists";
            return false;
        }else{
            return true;
        } 
    }
}

?>