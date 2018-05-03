<?php
namespace Models;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class User {

   private $id;
   private $first_name;
   private $last_name;
   private $email;
   private $password;
   private $code;
   private $is_active;
   private $date;


   public function setData(array $data){
      $this->id = $data['id'];
      $this->first_name = $data['first_name'];
      $this->last_name = $data['last_name'];
      $this->email = $data['email'];
      $this->password = $data['password'];
      $this->code = $data['code'];
      $this->is_active = $data['is_active'];
      $this->date = $data['date'];
   }

   public function getId() {
      return $this->id;
   }

   public function getFirstName(){
      return $this->first_name;
   }

   public function setFirstName(string $first_name){
      $this->first_name = $first_name;
   }

   public function getLastName(){
      return $this->last_name;
   }

   public function setLastName(string $last_name){
      $this->last_name = $last_name;
   }

   public function getPassword(){
      return $this->password;
   }

   public function setPassword(string $password){
      $this->password = $password;
   }

   public function getEmail(){
      return $this->email;
   }

   public function setEmail(string $email){
      $this->email = $email;
   }

   public function getCode(){
      return $this->code;
   }

   public function setCode(string $code){
      $this->code = $code;
   }

   public function getIsActive(){
      return $this->is_active;
   }

   public function setIsActive(string $is_active){
      $this->is_active = $is_active;
   }

   public function getDate(){
      return $this->date;
   }

   public function setDate(string $date){
      $this->date = $date;
   }

}