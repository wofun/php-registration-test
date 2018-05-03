<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Request {

   private static $instance;

   private $controller = 'IndexController';
   private $action = 'indexAction';
   private $params = [];

   private function __construct(){
      $uri = trim($_SERVER['REQUEST_URI'], '/');
      
      if (!empty($uri)) {
         $uriArr = explode('/', $uri);

         $this->controller = ucfirst(strtolower($uriArr[0])) . 'Controller';

         if (!empty($uriArr[1]))
            $this->action = str_replace(['-'],'_', strtolower($uriArr[1])) . 'Action';
         
         if (!empty($uriArr[2])) {
            $this->params = [];
            $params = array_slice($uriArr, 2);

            if (count($params > 1)){
               for ($i=0; $i < count($params); $i=$i+2){
                  if (isset($params[$i+1]))
                     $this->params[$params[$i]] = $params[$i+1];
               }
            }
         }
      }
   }

   static public function getInstance(){
      if (!isset(self::$instance)){
         self::$instance = new self();
      }

      return self::$instance;
   }

   public function getController() : string {
      return $this->controller;
   }

   public function getAction() : string {
      return $this->action;
   }

   public function getParams() : array {
      return $this->params;
   }

   public function getSanitizingPost() : ?array{
      if (empty($_POST)) return null;

      foreach($_POST as $key => $value){
         $_POST[$key] = filter_var(strip_tags(trim($value)), FILTER_SANITIZE_STRING);
      }
      return $_POST;
   }

   public function redirect(string $location = '') {
      header('Location: '.get_base_url() . '/' . trim($location,'/'));
      exit;
   }

}