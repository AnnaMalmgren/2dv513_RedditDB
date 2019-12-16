<?php

namespace Model;

require_once("DBConnection.php");

 class DBSeeder {

     private $mysqli;

     private $valuesPost = "";

     private $valuesSubreddit = "";
     
     public function __construct(DBConnection $db, bool $withConstraints)
     {
        $this->mysqli = $db->getMysqli();
        $this->createTables($withConstraints, $db);
     }

     public function createTables(bool $withConstraints, $db) {
        $sqlPostTable = $db->getPostTableQuery($withConstraints);
        $sqlSubredditTable = $db->getSubredditTableQuery($withConstraints);
        
        if(!$this->mysqli->query($sqlPostTable)) {
         throw new \Exception("Error in creating post Table" . $this->mysqli->error);
        }

        if(!$this->mysqli->query($sqlSubredditTable)) {
         throw new \Exception("Error in creating subreddit Table" . $this->mysqli->error);
        }
     }

     public function addQueryValues($paramValues) {
        
      $id = $paramValues['id'];
      $parent_id = $paramValues['parent_id'];
      $link_id = $paramValues['link_id'];
      $name = $paramValues['name'];
      $author = $paramValues['author'];
      $body = $this->mysqli->real_escape_string($paramValues['body']);
      $subreddit_id = $paramValues['subreddit_id'];
      $subreddit = $paramValues['subreddit'];
      $score = $paramValues['score'];
      $created_utc = date("Y-m-d H-i-s", $paramValues['created_utc']);
      
      $this->valuesPost .= "('$id', '$parent_id', '$link_id', '$name', '$author', '$body', '$subreddit_id', '$score', '$created_utc'),";
      $this->valuesSubreddit .= "('$subreddit_id', '$subreddit'),";
     }


     public function executeStmt() {
        $queryPostValues = $this->getQueryValues($this->valuesPost);
        $sqlPost = "INSERT into post VALUES $queryPostValues";

        $querySubredditValues = $this->getQueryValues($this->valuesSubreddit);
        $sqlSubreddit = "INSERT into subreddit (id, name) VALUES $querySubredditValues";

        if(!$this->mysqli->query($sqlPost)) {
         throw new \Exception("Error in query" . $this->mysqli->error);
        }

        if(!$this->mysqli->query($sqlSubreddit)) {
         throw new \Exception("Error in query" . $this->mysqli->error);
        }

        $this->resetValues();
     }

     private function resetValues() {
        $this->valuesPost = "";
        $this->valuesSubreddit = "";
     }
     
     // Removes the last space and comme from values string. 
     private function getQueryValues(string $values) : string {
        return substr($values, 0, -1);
     }
    
}
