<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');
use PDO;

class DB{
   static private $instance;

   private function __construct(){
      self::$instance = new PDO('sqlite:'.DB_NAME);
      self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
   }

   static public function getInstance(){
      if (!isset(self::$instance)){
         new self();
      }

      return self::$instance;
   }
}