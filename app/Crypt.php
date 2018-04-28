<?php
namespace Base;

include_once BASEDIR.'/libs/Bcrypt.php';

class Crypt {
   private $bcrypt;

   public function __construct() {
      $this->bcrypt = new \Bcrypt();
   }

   public function generateCode() : String {
      return bin2hex(random_bytes(10));
   }

   /**
   ** Create Bcrypt hash
   **/
   public function hash(String $str) : String {
      return $this->bcrypt->hash($str);
   }


   /**
   ** Verify Bcrypt pass
   **/
   public function verify(String $pass, String $pass_hash): bool{
      return $this->bcrypt->verify($pass, $pass_hash);
   }

}