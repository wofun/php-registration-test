<?php
namespace Models;
defined('ROOT_DIR') OR exit('No direct script access allowed');

use App\{DBMapper, ErrorList};

class UserMapper extends DBMapper {

   public function getTableName() : string {
      return 'users';
   }

   public function getByEmail(string $email) : ?User {
      $sql = "SELECT * FROM users WHERE email = :email";

      $pdo_st = $this->prepareAndBindData($sql, ['email' => $email]);
      $pdo_st->execute();

      $result = $pdo_st->fetch(\PDO::FETCH_ASSOC);

      if (!$result) return null;

      $user = new User();
      $user->setData($result);

      return $user;
   }


   public function getByCode(string $code) : ?User {
      $sql = "SELECT * FROM users WHERE code = :code AND is_active=0 LIMIT 1";

      $pdo_st = $this->prepareAndBindData($sql, ['code' => $code]);
      $pdo_st->execute();

      $result = $pdo_st->fetch(\PDO::FETCH_ASSOC);

      if (!$result) return null;

      $user = new User();
      $user->setData($result);

      return $user;
   }


   public function save(User $user) {
      $data = [
         'first_name' => $user->getFirstName(),
         'last_name' => $user->getLastName(),
         'email' => $user->getEmail(),
         'password' => $user->getPassword(),
         'code' => $user->getCode(),
         'is_active' => $user->getIsActive(),
         'date' => $user->getDate(),
      ];

      if ($id = $user->getId()) {
         return parent::update($data, 'id='.(int)$id);
      }
      else {
         return parent::insert($data);
      }
   }


   public function validateLogin(array $data, ErrorList $errorList) : bool {
      // Validation
      if (empty($data['email'])) {
         $errorList->setError('email', 'Enter your email');
      }
      elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
         $errorList->setError('email', 'Wrong email format');
      }

      if (empty($data['password'])) {
         $errorList->setError('password', 'Enter password');
      }
      elseif (strlen($data['password']) < 8 || strlen($data['password']) > 20) {
         $errorList->setError('password', 'Must be 8-20 characters long');
      }

      return ($errorList->get()) ? false : true;
   }


   public function validateRegistration(array $data, ErrorList $errorList) : bool {
      if ($this->validateLogin($data, $errorList) === true) {
         if (empty($data['password_confirm'])) {
            $errorList->setError('password_confirm', 'Repeat password');
         }
         elseif($data['password_confirm'] !== $data['password']) {
            $errorList->setError('password', 'Passwords do not match');
         }
      
         $userExists = $this->getByEmail($data['email']);
         if ($userExists){
            $errorList->setError('email', "This email is already registered");
         }
      }

      return ($errorList->get()) ? false : true;
   }


   public function validateEdit(array $data, ErrorList $errorList) : bool {
      if (!empty($data['password'])) {
         if (strlen($data['password']) < 8 || strlen($data['password']) > 20) {
            $errorList->setError('password', 'Must be 8-20 characters long');
         }

         if (empty($data['password_confirm'])) {
            $errorList->setError('password_confirm', 'Repeat password');
         }
         elseif($data['password_confirm'] !== $data['password']) {
            $errorList->setError('password', 'Passwords do not match');
         }

         if (empty($data['password_current'])) {
            $errorList->setError('password_current', 'Enter current password');
         }
      }

      return ($errorList->get()) ? false : true;
   }
}