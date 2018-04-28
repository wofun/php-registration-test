<?php
namespace Controllers;
use Base\{Controller, Crypt};
use Models\Users;

class UserController extends Controller{

   public function indexAction(){
      if (empty($_SESSION['loggedIn']))
         $this->redirect('/sign/in');

      $this->view->render('user.index');
   }

   public function editAction(){
      $data = [];
      $errors = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $users = new Users();
         $crypt = new Crypt();

         $data = array_map('trim', $_POST);
         $data['email'] = $_SESSION['user']['email'];

         $user = $users->getByEmail($_SESSION['user']['email']);

         // Validation
         if (!empty($data['password'])) {
            if (strlen($data['password']) < 8 || strlen($data['password']) > 20){
               $errors['password'] = 'Must be 8-20 characters long';
            }

            if (empty($data['password_confirm'])) {
               $errors['password_confirm'] = 'Repeat password';
            }
            elseif($data['password_confirm'] !== $data['password']){
               $errors['password'] = 'Passwords do not match';
            }

            if (empty($data['password_current'])) {
               $errors['password_current'] = 'Enter current password';
            }
         }

         if (empty($errors)){
            if (!empty($data['password'])) {
               
               if (!$crypt->verify($data['password_current'], $user['password'])) {
                  $errors['password_current'] = "Incorrect current password ";
               }
            }
         }

         // Update the data
         if (empty($errors)){
            $updateData = [
               'first_name' => $data['first_name'] ?? '',
               'last_name' => $data['last_name'] ?? '',
            ];

            if (!empty($data['password'])) {
               $updateData['password'] = $crypt->hash($data['password']);
            }

            if ($users->update($updateData, 'id = '.(int)$user['id'])){
               $_SESSION['user']['first_name'] = $updateData['first_name'];
               $_SESSION['user']['last_name'] = $updateData['last_name'];

               $data['saved'] = true;
            }
         }
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