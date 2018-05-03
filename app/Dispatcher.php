<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Dispatcher {

   public function dispatch(Request $request) {
      $controller = $request->getController();
      $action = $request->getAction();

      $controllerFile = $this->getControllerFilePath($controller);

      try{
         if (!is_readable($controllerFile)) 
            throw new \ErrorException("Controller file not found", 404);
         
         include_once $controllerFile;

         $className = 'Controllers\\'.$controller;

         if (!class_exists($className))
            throw new \ErrorException("Controller class not found", 404);

         $oController = new $className();

         if (!method_exists($oController, $action))
            throw new \ErrorException("Controller action method not found", 404);

         return (new $className)->{$action}();
      }
      catch(\ErrorException $e){
         // echo "Dispatcher error";
         header("HTTP/1.0 404 Not Found");
         return (new Controller())->page404();
      }
   }

   private function getControllerFilePath($controller) {
      return ROOT_DIR . DS .'app' . DS . 'Controllers' . DS . $controller . '.php';
   }

}
