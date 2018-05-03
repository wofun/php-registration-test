<?php
namespace App;

/**
** Storage of Error List 
**/
class ErrorList {
   private $errors = [];

   public function setError(string $key, string $msg){
      $this->errors[$key] = $msg;
   }

   public function get() : array{
      return $this->errors;
   }
}