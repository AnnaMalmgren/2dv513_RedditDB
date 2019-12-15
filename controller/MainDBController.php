<?php
namespace Controller;
ini_set('max_execution_time', 0);
set_time_limit(0);

session_start();

class MainDBController {

   private $db;
   
   private $file;
   
   private $timer;

   private $rowCount = 0;

    public function __construct(\Model\DBSeeder $db, \Model\File $file, \View\TimeDisplay $timer)
    {
        $this->db = $db;
        $this->file = $file->getFile();
        $this->timer = $timer;
    }

   
    public function populateDB() {
       $this->timer->displayStartTime($this->getTime());

        $this->insertValuesInDB();

        $this->timer->displayEndTime($this->getTime());
        fclose($this->file);
    }

    private function getTime() : string {
        return date("h:i:sa");
    }

    private function insertValuesInDB() {
        while (($row = fgets($this->file)) !== false) {
            $this->rowCount ++;
            $json = json_decode($row, true);
            $this->db->addQueryValues($json);
            $this->executeValueInsert();
        }
    }

    private function executeValueInsert() {
        // if larget than 3000 get package to big exception.
        if ($this->rowCount > 3000 || feof($this->file))
        {  
            $this->db->executeStmt();
            $this->rowCount = 0;
        }
    }
}
