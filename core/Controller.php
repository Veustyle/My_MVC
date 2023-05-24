<?php

require CORE . DS . 'Model.php';

abstract class Controller {

   protected string $layout = 'default';
   public array $variables;

   public function render (string $directory, string $view) : void
   {
      extract($this->variables);

      $view = ROOT . DS . 'views' . DS . $directory . DS . $view . '.php';

      ob_start();
      require($view);
      $pageContent = ob_get_clean();
      require ROOT . DS . 'views' . DS . 'layouts' . DS . $this->layout . '.php';
   }

   public function set (string $key, mixed $value) : void
   {
      $this->variables[$key] = $value;
   }

   public function error (string $message) : void
   {
      header('HTTP/1.0 404 NOT FOUND');
      $this->set('message', $message);
      $this->render('errors', '404');
      die();
   }
}