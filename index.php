<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

define('DS', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(__FILE__));

include_once BASEDIR.DS.'config.php';


function get_base_url(): string{
   $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ?
       'https' : 'http';

   $url = $protocol.'://'.$_SERVER['SERVER_NAME'];

   if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
      $url .= ':'.$_SERVER['SERVER_PORT'];
   }
   return $url;
}

### Autoloader ###
spl_autoload_register(function($class){
   $classFile = BASEDIR . DS . 'app' . DS . str_replace(['Base\\','\\'], ['', DS], $class) . '.php';
   // var_dump($class);
   // var_dump($classFile);

   if (is_readable($classFile)) {
      require_once $classFile;
   }
   else{
      throw new Error("Class file not found: " . $classFile);
   }
});


use Base\Dispatcher;

Dispatcher::dispatch();