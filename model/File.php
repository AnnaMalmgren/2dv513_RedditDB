<?php

namespace Model;

class File {

   private $path;

   private $file;

   public function __construct(string $filePath) {
       $this->path = $filePath;
       $this->unZipFile();
   }

   public function getFile() {
      return $this->file;
   }

   private function unZipFile() {
      $this->file = bzopen($this->path, "r");
      if (!$this->file)
      {
          throw new \Exception("File couldn't unzip");
      }
   }

}