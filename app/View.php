<?php
namespace App;
defined('ROOT_DIR') OR exit('No direct script access allowed');

class View{
   private const DIR = ROOT_DIR . DIRECTORY_SEPARATOR . 'templates';

   public function render(string $template, array $data = []){
      if (!file_exists(self::DIR . DIRECTORY_SEPARATOR . $template . '.php'))
         throw new \Exception("Template \"$template.php\" not found");

      foreach ($data as $key => $value)
        if ($key !== 'template') ${$key} = $value;

      include self::DIR . DIRECTORY_SEPARATOR . $template . '.php';
   }


   public function fetch(string $template, array $data = []) {
      ob_start();
      $this->render($template, $data);
      return ob_get_clean();
   }
}