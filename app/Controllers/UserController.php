<?php
namespace Controllers;
defined('ROOT_DIR') OR exit('No direct script access allowed');

use App\{Controller, Crypt, ErrorList};
use Models\{User, UserMapper};

class UserController extends Controller {

   public function indexAction() {
      if (empty($_SESSION['loggedIn']))
         $this->request->redirect('/sign/in');

      $this->view->render('user.index');
   }



   public function editAction() {
      if (empty($_SESSION['loggedIn']))
         $this->request->redirect('/sign/in');
      
      $errors = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = $this->request->getSanitizingPost();

         $mapper = new UserMapper();
         $user = $mapper->getByEmail($_SESSION['user']['email']);

         $crypt = new Crypt();
         $errorList = new ErrorList();
         if ($mapper->validateEdit($data, $errorList) === true) {
            if (!empty($data['password'])) {
               if (!$crypt->verify($data['password_current'], $user->getPassword())) {
                  $errors['password_current'] = "Incorrect current password ";
               }
            }
         }
         else{
            $errors = $errorList->get();
         }

         // Update the data
         if (empty($errors)){
            $user->setFirstName($data['first_name'] ?? '');
            $user->setLastName($data['last_name'] ?? '');
            
            if (!empty($data['password'])) {
               $user->setPassword($crypt->hash($data['password']));
            }

            if ($mapper->save($user)){
               $_SESSION['user']['first_name'] = $user->getFirstName();
               $_SESSION['user']['last_name'] = $user->getLastName();

               $data['saved'] = true;
            }
         }

         $data['email'] = $_SESSION['user']['email'];
      }
      else{
         $data = $_SESSION['user'];
      }

      $this->view->render('user.edit', [
         'page' => [
            'html_title' => 'Edit User data'
         ],
         'data' => $data,
         'errors' => $errors
      ]);
   }


}