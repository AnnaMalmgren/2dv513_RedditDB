<?php

namespace Model;

require_once("DbSettings.php");

class DBConnection {

    private $mysqli;

    public function __construct() {
        $this->connectDB();
    }

    public function getMysqli() {
        return $this->mysqli;
    }


    public function connectDB() {
        $this->mysqli = mysqli_connect(getenv('DBHOST'), getenv('DBUSER'), getenv('DBPASSWORD'), getenv('DBNAME'));

        if ($this->mysqli -> connect_errno) {
            throw new \Exception("Failed to connect to MySQL: " . $mysqli -> connect_error);
        } 
    }

}