<?php

final class Routeur {

   private string $url;
   private string $controller;
   private string $action;
   private array $params;

   public function __construct ()
   {
      $this -> url = $_SERVER['PATH_INFO'] ?? '/home/index';
      $this -> parse($this -> url);

      $controller = $this -> loadController();

      if (!in_array($this -> action, get_class_methods($controller))) {
         $controller -> error('Le controleur ' . $this -> controller . ' na pas de méthode ' . $this -> action);
      }

      $controller -> variables['params'] = $this -> params;
      $controller -> {$this->action}();
   }

   private function parse (string $url) : void
   {
      $url = trim($url, '/');
      $params = explode('/', $url);
      $this -> controller = $params[0] ?? 'home';
      $this -> action = $params[1] ?? 'index';
      $this -> params = array_slice($params, 2) ?? [];
   }

   private function loadController () : Controller
   {
      $name = ucfirst($this -> controller) . 'Controller';
      $file = ROOT . DS . 'controllers' . DS . $name . '.php';

      if (file_exists($file)) {
         require $file;
         return new $name();
      } else {
         require ROOT . DS .'controllers/ErrorsController.php';
         $controller = new ErrorsController();
         $controller -> error('Le controleur ' . $this -> controller . ' n existe pas');
         return $controller;
      }
   }
}