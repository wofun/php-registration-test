<?php
namespace Controllers;
defined('ROOT_DIR') OR exit('No direct script access allowed');

use App\{Controller, Crypt, Email, ErrorList};
use Models\{User, UserMapper};

class SignController extends Controller {

   /** 
   ** Login Action
   **/
   public function inAction() {
      if (!empty($_SESSION['loggedIn']))
         $this->request->redirect('/user/');

      $mapper = new UserMapper();

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = $this->request->getSanitizingPost();

         $errorList = new ErrorList();

         if ($mapper->validateLogin($data, $errorList) === true) {
            $crypt = new Crypt();

            $user = $mapper->getByEmail($data['email']);

            $errors = [];
            if ($user === null || !$crypt->verify($data['password'], $user->getPassword())) {
               $errors['password'] = "Incorrect email or password ";
            }
            elseif ($user->getIsActive() === 0) {
               $errors['email'] = "Account is not active. Please confirm the registration by e-mail.";
            }
            else {
               $_SESSION['loggedIn'] = true;
               $_SESSION['user'] = [
                  'first_name' => $user->getFirstName(),
                  'last_name' => $user->getLastName(),
                  'email' => $user->getEmail(),
                  'date' => $user->getDate(),
               ];

               $this->request->redirect('user');
            }
         }
         else{
            $errors = $errorList->get();
         }
      }
      else{
         if (!empty($_SESSION['registration_success'])) {
            $registration_success = true;
            unset($_SESSION['registration_success']);
         }
      }

      $this->view->render('login', [
         'page' => [
            'html_title' => 'Login'
         ],
         'data' => $data ?? [],
         'registration_success' => $registration_success ?? false,
         'errors' => $errors ?? false
      ]);
   }



   /**
   ** Logout Action
   **/
   public function outAction() {
      unset($_SESSION['loggedIn']);
      unset($_SESSION['user']);
      session_destroy();
      $this->request->redirect('/sign/in');
   }



   /**
   ** Registration action
   **/
   public function upAction() {
      if (!empty($_SESSION['loggedIn']))
         $this->request->redirect('/user');

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         $data = $this->request->getSanitizingPost();

         $mapper = new UserMapper();
         $errorList = new ErrorList();

         if ($mapper->validateRegistration($data, $errorList) === true) {
            $crypt = new Crypt();
            $email = new Email();

            $user = new User();
            $user->setFirstName($data['first_name'] ?? '');
            $user->setLastName($data['last_name'] ?? '');
            $user->setEmail($data['email']);
            $user->setPassword($crypt->hash($data['password']));
            $user->setCode($crypt->generateCode());
            $user->setIsActive(0);
            $user->setDate(date('Y-m-d H:i:s'));

            if ($mapper->save($user)){
               $message = $msg = $this->view->fetch('email.registration.confirmation', ['first_name' => $user->getFirstName(), 'code' => $user->getCode()]);
               $email->send($data['email'], 'Registration confirmation', $message, SITE_EMAIL);

               $this->request->redirect('sign/info/');
            }
         }
         else{
            $errors = $errorList->get();
         }
      }

      $this->view->render('registration', [
         'page' => [
            'html_title' => 'Registration'
         ],
         'data' => $data ?? [],
         'errors' => $errors ?? false
      ]);
   }



   /** 
   ** Registration confirmation action
   **/
   public function confirmationAction(){
      $params = $this->request->getParams();

      if (empty($params['code'])) 
         $this->request->redirect('/');

      $mapper = new UserMapper();
      $user = $mapper->getByCode($params['code']);

      if (!$user)
         $this->request->redirect('/');
      
      $user->setCode('');
      $user->setIsActive(1);

      if ($mapper->save($user)) {
         $_SESSION['registration_success'] = true;
      }

      $this->request->redirect('/sign/in/');
   }


   /**
   ** Registration Info page action
   **/
   public function infoAction(){
      $this->view->render('registration.info');
   }
}