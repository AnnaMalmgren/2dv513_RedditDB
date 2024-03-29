<?php

namespace Model;

require_once(__DIR__ . '/../settings.php');

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

        if ($this->mysqli->connect_errno) {
            throw new \Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
        } 
    }

    public function getPostTableQuery(bool $withConstraints) : string {
        return 
        $withConstraints ? $this->postTableConstraintsOn() : $this->postTableConstraintsOff();
    }

    public function getSubredditTableQuery(bool $withConstraints) : string {
        return 
        $withConstraints ? $this->subredditTableConstraintsOn() : $this->subbredditTableConstraintsOff();
    }

    private function postTableConstraintsOff() : string {
        return "CREATE TABLE IF NOT EXISTS post (
            id varchar(50),
            parent_id varchar(50),
            link_id varchar(50),
            name varchar(50),
            author varchar(50),
            body longtext,
            subreddit_id varchar(50),
            score int(11),
            created_utc datetime
          )";
    }

    private function subbredditTableConstraintsOff() : string { 
        return "CREATE TABLE IF NOT EXISTS subreddit (
            name VARCHAR(50), 
            id VARCHAR(50)
            )";
    }

    private function postTableConstraintsOn() : string {
        return "CREATE TABLE IF NOT EXISTS post(
            id varchar(50) NOT NULL,
            parent_id varchar(50) NOT NULL,
            link_id varchar(50) NOT NULL,
            name varchar(50) NOT NULL UNIQUE,
            author varchar(50) NOT NULL,
            body longtext NOT NULL,
            subreddit_id varchar(50) NOT NULL,
            score int(11) NOT NULL,
            created_utc datetime NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(subreddit_id) REFERENCES subreddit(id)
          )";
    }

    public function addForeignKey() {
        return "ALTER TABLE post ADD CONSTRAINT FOREIGN KEY(subreddit_id) REFERENCES subreddit(id)";
    }

    private function subredditTableConstraintsOn() : string {
        return "CREATE TABLE IF NOT EXISTS subreddit(
            name VARCHAR(50) NOT NULL, 
            id VARCHAR(50) PRIMARY KEY
            )";
    }

}