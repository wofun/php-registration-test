<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Crypt {
   const BCRYPT_COST = 12;

   /** 
   ** Generate randome code 
   **/
   public function generateCode() : string {
      return bin2hex(random_bytes(10));
   }

   /**
   ** Create password Bcrypt hash
   **/
   public function hash(string $str) : string {
      return password_hash($str, PASSWORD_BCRYPT, ['cost' => self::BCRYPT_COST]);
   }


   /**
   ** Verify pass
   **/
   public function verify(string $pass, string $pass_hash): bool{
      return password_verify($pass, $pass_hash);
   }

}