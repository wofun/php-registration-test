<?php
namespace Controllers;
defined('ROOT_DIR') OR exit('No direct script access allowed');
use App\Controller;

class IndexController extends Controller {

   public function indexAction() {

      if ($_SESSION['loggedIn']){
         $this->request->redirect('/user');
      }
      else{
         $this->request->redirect('/sign/in');
      }
      
      $this->view->render('index');
   }
}