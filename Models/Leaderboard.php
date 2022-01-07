<?php

include_once("../includes/dbconnect.php");

/**
 * @Description This is the the Class for the leaderboard
 */

class Leaderboard extends dbConnect
{

    /**
     * @description The function is used to get insert the username
     * and score into the leaderboard table. Score will be initially
     * set to 0.
     */

    public function createLeaderboard($username)
    {
        $sqlLeaderboard = "INSERT INTO leaderboard (username,score) VALUES ('$username',0)";
        $resultLeaderboard = mysqli_query($this->dbconnect(), $sqlLeaderboard);

        if (!$resultLeaderboard) {
            //sql error
            echo "Error: " . $sqlLeaderboard . "<br>" . mysqli_error($this->dbconnect());
        }
    }
}
