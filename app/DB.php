<?php
namespace Base;

class DB extends \SQLite3 {
   protected $table;

   public function __construct() {
      $this->open(DB_NAME);
   }

   public function setTable(string $name) : void{
      $this->table = $name;
   }


   public function insert(array $data) {
      if (empty($this->table))
         throw new \Exception("DB: Table undefined");

      // Build SQL
      $sql = "INSERT INTO {$this->table} (".implode(array_keys($data), ',').") VALUES (";
      foreach ($data as $key => $value){
         $sql .= ":{$key}, ";
      }
      $sql = rtrim($sql, ', '). ')';

      // Prepare SQL
      $stmt = $this->prepare($sql);
      foreach ($data as $key => $value) {
         if (is_string($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_TEXT);
         }
         elseif (is_int($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_INTEGER);
         }
         elseif (is_float($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_FLOAT);
         }
         else{
            $stmt->bindValue(":{$key}", $value, SQLITE3_TEXT);
         }
         
      }

      return $result = $stmt->execute();
   }

   public function update(array $data, string $condition) {
      if (empty($this->table))
         throw new \Exception("DB: Table undefined");

      // Build SQL
      $sql = "UPDATE {$this->table} SET ";
      foreach ($data as $key => $value){
         $sql .= "{$key}=:{$key}, ";
      }
      $sql = rtrim($sql, ', ') . ' WHERE '.$condition;

      // Prepare SQL
      $stmt = $this->prepare($sql);

      foreach ($data as $key => $value) {
         if (is_string($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_TEXT);
         }
         elseif (is_int($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_INTEGER);
         }
         elseif (is_float($value)){
            $stmt->bindValue(":{$key}", $value, SQLITE3_FLOAT);
         }
         else{
            $stmt->bindValue(":{$key}", $value, SQLITE3_TEXT);
         }
         
      }

      return $result = $stmt->execute();
   }


}