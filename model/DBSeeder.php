<?php

namespace Model;

require_once("DBConnection.php");

 class DBSeeder {

     private $mysqli;

     private $values = "";
     
     public function __construct(DBConnection $db)
     {
        $this->mysqli = $db->getMysqli();
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
      
      $this->values .= "('$id', '$parent_id', '$link_id', '$name', '$author', '$body', '$subreddit_id', '$subreddit', '$score', '$created_utc'), ";
    
     }


     public function executeStmt() {
        $queryValues = $this->getQueryValues();
        $sql = "INSERT into reddit_post VALUES $queryValues";

        if(!$this->mysqli->query($sql)) {
         throw new \Exception("Error in query" . $this->mysqli->error);
     }

        $this->resetValues();
     }

     private function resetValues() {
        $this->values = "";
     }
     
     // Removes the last space and comme from values string. 
     private function getQueryValues() : string {
        return substr($this->values, 0, -2);
     }
    
}
