<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Controller{
   protected $request;
   protected $view;

   public function __construct(){
      $this->request = Request::getInstance();
      $this->view = new View();
   }

   public function page404(){
      $this->view->render('404', [
         'page' => [
            'html_title' => '404'
         ]
      ]);
   }

   
}