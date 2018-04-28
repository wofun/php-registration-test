<?php
namespace Base;

class Dispatcher {
   static private $controller = 'IndexController';
   static private $action = 'indexAction';
   static private $params = [];

   static public function dispatch() {
      $uri = trim($_SERVER['REQUEST_URI'], '/');
      
      if (!empty($uri)) {
         $uriArr = explode('/', $uri);

         self::$controller = ucfirst(strtolower($uriArr[0])) . 'Controller';

         if (!empty($uriArr[1]))
            self::$action = str_replace(['-'],'_', strtolower($uriArr[1])) . 'Action';
         
         if (!empty($uriArr[2])) {
            self::$params = [];
            $params = array_slice($uriArr, 2);

            if (count($params > 1)){
               for ($i=0; $i < count($params); $i=$i+2){
                  if (isset($params[$i+1]))
                     self::$params[$params[$i]] = $params[$i+1];
               }
            }
         }
      }

      $controllerFile = self::getControllerFilePath(self::$controller);

      try{
         if (!is_readable($controllerFile)) 
            throw new \ErrorException("Controller file not found", 404);
         
         include_once $controllerFile;

         $className = 'Controllers\\'.self::$controller;

         if (!class_exists($className))
            throw new \ErrorException("Controller class not found", 404);

         $oController = new $className();

         if (!method_exists($oController, self::$action))
            throw new \ErrorException("Controller action method not found", 404);

         return (new $className)->{self::$action}();
      }
      catch(\ErrorException $e){
         // echo "Dispatcher error";
         header("HTTP/1.0 404 Not Found");
         return (new Controller())->page404();
      }
   }

   static private function getControllerFilePath($controller) {
      return BASEDIR . DS .'app' . DS . 'Controllers' . DS . $controller . '.php';
   }

   static public function getController() {
      return self::$controller;
   }
   static public function getAction() {
      return self::$action;
   }
   static public function getParams() {
      return self::$params;
   }
}
