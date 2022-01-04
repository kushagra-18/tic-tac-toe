<?php

// Connecting to the Database

class dbConnect
{

    public function dbconnect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "tictactoe";

        error_reporting(E_ERROR | E_PARSE);

        // $servername = "l6glqt8gsx37y4hs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        // $username = "zdufljbxx02ayg0j";
        // $password = "xx70c4amyg6ipj30";
        // $database = "zll74kkke20ditz2";

        // Create a connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        try {
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // echo "Connected successfully";
        } catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $conn;

    }
}
