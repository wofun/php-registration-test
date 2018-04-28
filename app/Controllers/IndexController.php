<?php
namespace Controllers;
use Base\Controller;

class IndexController extends Controller {

   public function indexAction() {

      if ($_SESSION['loggedIn']){
         $this->redirect('/user');
      }
      else{
         $this->redirect('/sign/in');
      }
      
      $this->view->render('index');
   }
}