<?php
namespace Base;

class View{
   private const DIR = BASEDIR . DIRECTORY_SEPARATOR . 'templates';

   public function render(String $template, Array $data = []){
      if (!file_exists(self::DIR . DIRECTORY_SEPARATOR . $template . '.php'))
         throw new \Exception("Template \"$template.php\" not found");

      foreach ($data as $key => $value)
         ${$key} = $value;

      include self::DIR . DIRECTORY_SEPARATOR . $template . '.php';
   }


   public function fetch(string $template, array $data = []) {
      ob_start();
      $this->render($template, $data);
      return ob_get_clean();
   }
}