<?php
namespace Models;
use Base\DB;

class Users extends DB {

   public function __construct(){
      parent::__construct();

      $this->setTable('users');
   }

   public function createTable(){
      $this->exec('CREATE TABLE IF NOT EXISTS users (
         id INTEGER PRIMARY KEY,
         first_name VARCHAR(255), 
         last_name VARCHAR(255), 
         email VARCHAR(255), 
         password VARCHAR(255), 
         code VARCHAR(255), 
         is_active BOOLEAN,
         date DATETIME)');
   }

   public function dropTable() {
      $this->exec('DROP TABLE IF EXISTS users');
   }

   public function deleteByIds(array $ids){
      $this->exec('DELETE FROM users WHERE id IN ('.implode(',', $ids).')');
   }

   public function getAll() {
      $results = $this->query('SELECT * FROM users');

      while ($row = $results->fetchArray()) {
          var_dump($row);
      }
   }

   public function getByEmail(string $email) : array {
      $res_data = [];

      $sql = "SELECT * FROM users WHERE email = :email";
      $smt = $this->prepare($sql);
      $smt->bindValue(':email', $email, SQLITE3_TEXT);

      $res = $smt->execute();
      while ($row = $res->fetchArray()) {
          $res_data = $row;
      }

      return $res_data;
   }

   public function getById(int $id) : array {
      return $this->querySingle("SELECT * FROM users WHERE id = ".(int)$id, true);
   }


   public function getByCode(string $code) : array {
      $data = [];

      $sql = "SELECT * FROM users WHERE code = :code AND is_active=0 LIMIT 1";

      $smt = $this->prepare($sql);
      $smt->bindValue(':code', $code, SQLITE3_TEXT);

      $res = $smt->execute();

      while ($row = $res->fetchArray()) {
         $data = $row;
      }

      return $data;
   }

   public function insert(array $data) {
      return parent::insert($data);
   }

   public function update(array $data, string $condition) {
      return parent::update($data, $condition);
   }

   
}