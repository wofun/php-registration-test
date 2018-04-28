<?php
namespace Base;

class Controller{
   protected $view;
   protected $db;

   public function __construct(){
      $this->view = new View();
   }

   public function page404(){
      $this->view->render('404', [
         'page' => [
            'html_title' => '404'
         ]
      ]);
   }

   public function redirect(string $location) {
      header('Location: '.get_base_url() . '/' . trim($location,'/'));
      exit;
   }
}