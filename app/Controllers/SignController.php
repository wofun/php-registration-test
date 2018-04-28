<?php
namespace Controllers;

use Base\{Controller, Crypt, Email, Dispatcher};
use Models\Users;

class SignController extends Controller {

   /** 
   ** Login Action
   **/
   public function inAction() {
      if (!empty($_SESSION['loggedIn']))
         $this->redirect('/user/');

      $data = [];
      $errors = [];

      if (!empty($_SESSION['registration_success'])) {
         $data['registration_success'] = true;
         unset($_SESSION['registration_success']);
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = array_map('trim', $_POST);

         // Validation
         if (empty($data['email'])) {
            $errors['email'] = 'Enter your email';
         }
         elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Wrong email format';
         }

         if (empty($data['password'])) {
            $errors['password'] = 'Enter password';
         }
         elseif (strlen($data['password']) < 8 || strlen($data['password']) > 20){
            $errors['password'] = 'Must be 8-20 characters long';
         }

         // Get user data
         if (empty($errors)){
            $users = new Users();
            $crypt = new Crypt();

            $user = $users->getByEmail($data['email']);

            if (!$user || !$crypt->verify($data['password'], $user['password'])) {
               $errors['password'] = "Incorrect email or password ";
            }
            elseif ($user['is_active'] === 0) {
               $errors['email'] = "Account is not active. Please confirm the registration by e-mail.";
            }
            else {
               $_SESSION['loggedIn'] = true;
               $_SESSION['user'] = [
                  'first_name' => $user['first_name'],
                  'last_name' => $user['last_name'],
                  'email' => $user['email'],
                  'date' => $user['date'],
               ];

               $this->redirect('user');
            }
         }
      }

      $this->view->render('login', [
         'page' => [
            'html_title' => 'Login'
         ],
         'data' => $data,
         'errors' => $errors
      ]);
   }



   /**
   ** Logout Action
   **/
   public function outAction() {
      unset($_SESSION['loggedIn']);
      unset($_SESSION['user']);

      session_destroy();
      $this->redirect('/sign/in');
   }

   /**
   ** Registration action
   **/
   public function upAction() {
      // $users->deleteByIds([1,2,3,4,5,6,7,8,9]);
      if (!empty($_SESSION['loggedIn']))
         $this->redirect('/user/');

      $data = [];
      $errors = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $users = new Users();

         $data = array_map('trim', $_POST);

         // Validation
         if (empty($data['email'])) {
            $errors['email'] = 'Enter your email';
         }
         elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Wrong email format';
         }

         if (empty($data['password'])) {
            $errors['password'] = 'Enter password';
         }
         elseif (strlen($data['password']) < 8 || strlen($data['password']) > 20){
            $errors['password'] = 'Must be 8-20 characters long';
         }
         else{
            if (empty($data['password_confirm'])) {
               $errors['password_confirm'] = 'Repeat password';
            }
            elseif($data['password_confirm'] !== $data['password']){
               $errors['password'] = 'Passwords do not match';
            }
         }

         // Check email exists
         if (empty($errors)){
            $userExists = $users->getByEmail($data['email']);
            if ($userExists){
               $errors['email'] = "This email is already registered";
            }
         }

         // Insert the data and send confirmation email
         if (empty($errors)){
            
            $crypt = new Crypt();
            $email = new Email();

            $insertData = [
               'first_name' => $data['first_name'] ?? '',
               'last_name' => $data['last_name'] ?? '',
               'email' => $data['email'],
               'password' => $crypt->hash($data['password']),
               'code' => $crypt->generateCode(),
               'is_active' => 0,
               'date' => date('Y-m-d H:i:s')
            ];

            if ($users->insert($insertData)){
               $message = $msg = $this->view->fetch('email.registration.confirmation', $insertData);
               $email->send($data['email'], 'Registration confirmation', $message, SITE_EMAIL);

               $this->redirect('sign/info/');
            }
         }
      }

      $this->view->render('registration', [
         'page' => [
            'html_title' => 'Registration'
         ],
         'data' => $data,
         'errors' => $errors
      ]);
   }



   /** 
   ** Registration confirmation action
   **/
   public function confirmationAction(){
      $params = Dispatcher::getParams();

      if (empty($params['code'])) 
         $this->redirect('/');

      $users = new Users();
      $user = $users->getByCode($params['code']);

      if (!$user)
         $this->redirect('/');
      
      // Activate user
      if ($users->update(['is_active' => 1, 'code' => ''], ' id = '.$user['id'])) {
         $_SESSION['registration_success'] = true;
      }

      $this->redirect('/sign/in/');
   }


   /**
   ** Registration Info page action
   **/
   public function infoAction(){
      $this->view->render('registration.info');
   }
}