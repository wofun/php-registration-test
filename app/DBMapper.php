<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');
use PDO;

abstract class DBMapper {
   private $pdo;

   final public function __construct() {
      $this->pdo = DB::getInstance();
   }

   abstract protected function getTableName() : string;

   public function insert(array $data) {
      $table = $this->getTableName();

      // Build SQL
      $sql = "INSERT INTO {$table} (".implode(array_keys($data), ',').") VALUES (";
      foreach ($data as $key => $value) {
         $sql .= ":{$key}, ";
      }
      $sql = rtrim($sql, ', '). ')';

      $pdo_st = $this->prepareAndBindData($sql, $data);
      return $result = $pdo_st->execute();
   }


   public function update(array $data, string $condition) {
      $table = $this->getTableName();

      // Build SQL
      $sql = "UPDATE {$table} SET ";
      foreach ($data as $key => $value){
         $sql .= "{$key}=:{$key}, ";
      }
      $sql = rtrim($sql, ', ') . ' WHERE '.$condition;

      $pdo_st = $this->prepareAndBindData($sql, $data);
      return $result = $pdo_st->execute();
   }


   public function prepareAndBindData(string $sql, array $data) {
      // Prepare SQL
      $pdo_st = $this->pdo->prepare($sql);
      foreach ($data as $key => $value) {
         $bindType = PDO::PARAM_STR;

         if (is_int($value)) {
            $bindType = PDO::PARAM_INT;
         }
         elseif (is_null($value)) {
            $bindType = PDO::PARAM_NULL;
         }

         $pdo_st->bindValue(":{$key}", $value, $bindType);
      }
      return $pdo_st;
   }
   
}